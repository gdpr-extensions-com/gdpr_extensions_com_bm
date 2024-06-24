<?php

namespace GdprExtensionsCom\GdprExtensionsComBm\Utility;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

class SyncBanners
{

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function run(ConnectionPool $connectionPool, Logger $logManager, SiteFinder $siteFinder, PathUtility $pathUtility)
    {
        $multilocationQB = $connectionPool->getQueryBuilderForTable('multilocations');

        $sysTempQB = $connectionPool->getQueryBuilderForTable('sys_template');

        $client = new Client();
        $promises = [];
        $apiKeys = [];


        $multilocationQBResult = $multilocationQB
            ->select('*')
            ->from('multilocations')
            ->executeQuery()
            ->fetchAllAssociative();


        foreach ($multilocationQBResult as $location) {

            $apiKey = $location['dashboard_api_key'] ?? null;

            $SiteConfiguration = $sysTempQB->select('constants')
                ->from('sys_template')
                ->where(
                    $sysTempQB->expr()->eq('pid', $sysTempQB->createNamedParameter($location['pages'])),
                )
                ->setMaxResults(1)
                ->executeQuery()
                ->fetchAssociative();
            $sysTempQB->resetQueryParts();

            $constantsArray = $this->extractSecretKey($SiteConfiguration['constants']);
            $BaseURL = isset($constantsArray['plugin.tx_gdprextensionscomcm_gdprextensionscomcm.settings.dashboardBaseUrl']) ? $constantsArray['plugin.tx_gdprextensionscomcm_gdprextensionscomcm.settings.dashboardBaseUrl']: null ;

            if ($apiKey) {
                $requestUrl = (is_null($BaseURL) ? 'https://dashboard.gdpr-extensions.com/': $BaseURL) . 'review/api/' . $location['dashboard_api_key'] . '/get-banners.json';

                $promises[] = $client->getAsync($requestUrl);
                $apiKeys[] = $location;
            }
        }

        $responses = Promise\Utils::settle($promises)->wait();
        $connection = $connectionPool->getConnectionForTable('tx_gdprextensionscombm_domain_model_localbanner');
        $flag = 0;


        foreach ($responses as $key => $response) {
            if ($response['state'] === 'fulfilled') {
                $banners = json_decode($response['value']->getBody()->getContents(), true, JSON_THROW_ON_ERROR);

                if(!$flag){
                    if(!empty($banners)){
                        $connection->executeStatement('UPDATE tx_gdprextensionscombm_domain_model_localbanner SET is_archived = 1');
                        $flag = 1;
                    }
                }

                foreach ($banners as $banner)
                {

                    if(!is_null($banner['status']) && $banner['status'] == 0){
                        $queryBuilder = $connection->createQueryBuilder();
                        $queryBuilder
                            ->update('tx_gdprextensionscombm_domain_model_localbanner')
                            ->where(
                                $queryBuilder->expr()->eq('campaign_id', $queryBuilder->createNamedParameter($banner['campaign_id'], \PDO::PARAM_INT))
                            )
                            ->set('campaign_is_disabled', 1)
                            ->execute();
                    }else{

                        $this->syncBanner($banner, $apiKeys[$key], $connectionPool, $logManager, $pathUtility);
                    }

                }
            }
        }

    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    private function syncBanner(array $banner, array $configuration, ConnectionPool $connectionPool, Logger $logManager, PathUtility $pathUtility)
    {
        $connection = $connectionPool->getConnectionForTable('tx_gdprextensionscombm_domain_model_localbanner');

        $existingBanner = $this->findBanner($banner['id'], $banner['campaign_id'], $configuration['pages'], $configuration['dashboard_api_key'], $connection);


        $banner = $this->processBanner($banner, $configuration['pages'],$configuration['dashboard_api_key'], $pathUtility);
        if ($existingBanner) {
            $connection->update(
                'tx_gdprextensionscombm_domain_model_localbanner',
                $banner,
                ['uid' => $existingBanner['uid']]
            );
        } else {
            $banner['root_pid'] = $configuration['pages'];
            $connection->insert('tx_gdprextensionscombm_domain_model_localbanner', $banner);
        }
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    private function findBanner($bannerId, $campaignId, $rootPid, $apiKey, Connection $connection): ?array
    {
        $qb = $connection->createQueryBuilder();
        $result = $qb
            ->select('*')
            ->from('tx_gdprextensionscombm_domain_model_localbanner')
            ->where(
                $qb->expr()->eq('banner_id', $qb->createNamedParameter($bannerId)),
                $qb->expr()->eq('campaign_id', $qb->createNamedParameter($campaignId)),
                $qb->expr()->eq('root_pid', $qb->createNamedParameter($rootPid)),
                $qb->expr()->eq('dashboard_api_key', $qb->createNamedParameter($apiKey))
            )
            ->executeQuery()
            ->fetchAssociative();

        return $result ?: null;
    }


    /**
     * @param array $banner
     * @param PathUtility $pathUtility
     * @return array
     */
    private function processBanner(array $banner, int $rootPid,string $apiKey, PathUtility $pathUtility): array
    {
        $bannerRootFolder = Environment::getPublicPath().'/fileadmin/banner_'.$banner['id'].'/';
        if (!is_dir($bannerRootFolder)) {
            mkdir($bannerRootFolder);
        }
        $banner['content_html'] = base64_decode($banner['content_html']);
        $banner['content_css'] = base64_decode($banner['content_css']);
        $banner['content_js'] = base64_decode($banner['content_js']);

        foreach ($banner['resources'] as $resource)
        {
            if (!is_dir($bannerRootFolder . $resource['type'])) {
                mkdir($bannerRootFolder . $resource['type']);
            }
            $resource_path = $bannerRootFolder . $resource['type'] . '/' . basename($resource['url']);
            if (!is_file($resource_path) || md5(file_get_contents($resource_path)) !=$resource['hash']) {
                $data = file_get_contents($resource['url']);
                if ($data!==false) {
                    file_put_contents($resource_path , $data);
                }
            }
            $requiredFormat = '/';
            $clean_path = preg_replace('#^/+#', '', $pathUtility::getAbsoluteWebPath($resource_path));
            $public_url = $requiredFormat . $clean_path;

            $pattern = "(###" . $resource['name']  . "###)i";

            $banner['content_html'] = preg_replace($pattern, $public_url, $banner['content_html']);
            $banner['content_css'] = preg_replace($pattern, $public_url, $banner['content_css']);
            $banner['content_js'] = preg_replace($pattern, $public_url, $banner['content_js']);

        }


        return [
            'banner_id' => $banner['id'],
            'banner_title' => $banner['title'],
            'banner_html' => $banner['content_html'],
            'banner_css' => $banner['content_css'],
            'banner_js' => $banner['content_js'],
            'valid_from' => $banner['valid_from'],
            'valid_to' => $banner['valid_to'],
            'root_pid' => $rootPid,
            'campaign_id' => $banner['campaign_id'],
            'campaign_title' => $banner['campaign_title'],
            'is_archived' => 0,
            'campaign_is_disabled' => 0,
            'dashboard_api_key' => $apiKey,

        ];
    }

    protected function extractSecretKey($constantsString)
    {
        $configLines = explode("\n", $constantsString);
        $configArray = [];

        foreach ($configLines as $line) {
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $configArray[trim($key)] = trim($value);
            }
        }
        return $configArray;
    }
}

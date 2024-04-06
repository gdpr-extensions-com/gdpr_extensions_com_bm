<?php

namespace GdprExtensionsCom\GdprExtensionsComBm\Utility;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

class UploadBannerStat
{

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function run(ConnectionPool $connectionPool, Logger $logManager, SiteFinder $siteFinder): void
    {
        $multilocationQB = $connectionPool->getQueryBuilderForTable('multilocations');

        $sysTempQB = $connectionPool->getQueryBuilderForTable('sys_template');

        $client = new Client();
        $currentTime = time();
        $fiveMinutesAgo = $currentTime - (115 * 60);

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
            $BaseURL = $constantsArray['plugin.tx_goapiconnect_goapiconnect.settings.dashboardBaseUrl'];

            if ($apiKey) {
                $gosignApiToken = $apiKey;
                $connection = $connectionPool->getConnectionForTable('tx_gdprextensionscombm_domain_model_bannerstat');
                try {
                    $queryBuilder = $connection->createQueryBuilder();
                    $stats = $queryBuilder
                        ->select('*')
                        ->from('tx_gdprextensionscombm_domain_model_bannerstat')
                        ->where(
                            $queryBuilder->expr()->gte('timestamp', $queryBuilder->createNamedParameter($fiveMinutesAgo, \PDO::PARAM_INT))
                        )
                        ->executeQuery()
                        ->fetchAllAssociative();

                    foreach ($stats as $stat) {
                        $bannerId = $stat['local_banner'];
                        $bannerInfo = $this->getBannerInfo($connection, $bannerId);

                        $data = [
                            'bannerId' => (int) $bannerInfo['banner_id'] ?? null,
                            'campaignId' => (int) $bannerInfo['campaign_id'] ?? null,
                            'timestamp' => $stat['timestamp'],
                            'impressions' => $stat['impressions'],
                        ];

                        try {
                            $client->post((is_null($BaseURL) ? 'https://dashboard.gosign.de/': $BaseURL) . "review/api/{$gosignApiToken}/save-banner-stats.json", [
                                'json' => $data,
                            ]);
                        } catch (GuzzleException $e) {
                            $logManager->error( $e->getMessage());
                        }
                    }
                } catch (\Exception $e) {
                    $logManager->error( $e->getMessage());
                }
            }
        }
    }

    /**
     *
     * @param \Doctrine\DBAL\Connection $connection
     * @param int $bannerId
     * @return array|null
     * @throws \Doctrine\DBAL\Exception
     */
    private function getBannerInfo($connection, $bannerId): ?array
    {
        $queryBuilder = $connection->createQueryBuilder();
        $bannerInfo = $queryBuilder
            ->select('*')
            ->from('tx_gdprextensionscombm_domain_model_localbanner')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($bannerId, \PDO::PARAM_INT))
            )
            ->execute()
            ->fetchAssociative();

        return $bannerInfo ?: null;
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

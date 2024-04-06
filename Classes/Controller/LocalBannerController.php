<?php

declare(strict_types=1);

namespace GdprExtensionsCom\GdprExtensionsComBm\Controller;


use GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\BannerStat;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "gdpr_extensions_com_bm" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023
 */

/**
 * LocalBannerController
 */
class LocalBannerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * localBannerRepository
     *
     * @var \GdprExtensionsCom\GdprExtensionsComBm\Domain\Repository\LocalBannerRepository
     */
    protected $localBannerRepository = null;

    /**
     * ContentObject
     *
     * @var ContentObject
     */
    protected $contentObject;

    /**
     * @var \GdprExtensionsCom\GdprExtensionsComBm\Domain\Repository\BannerStatRepository
     */
    protected $bannerStatRepository = null;

    /**
     * @param \GdprExtensionsCom\GdprExtensionsComBm\Domain\Repository\LocalBannerRepository $localBannerRepository
     */
    public function injectLocalBannerRepository(\GdprExtensionsCom\GdprExtensionsComBm\Domain\Repository\LocalBannerRepository $localBannerRepository)
    {
        $this->localBannerRepository = $localBannerRepository;
    }

    public function injectBannerStatRepository(\GdprExtensionsCom\GdprExtensionsComBm\Domain\Repository\BannerStatRepository $bannerStatRepository)
    {
        $this->bannerStatRepository = $bannerStatRepository;
    }

    /**
     * Action initialize
     */
    protected function initializeAction()
    {
        $this->contentObject = $this->configurationManager->getContentObject(); // intialize the content object
    }


    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    public function trackAction(): \Psr\Http\Message\ResponseInterface
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $bannerId = (int)$data['id'];
        $banner = $this->localBannerRepository->findByUid($bannerId);
        $type = $data['type'];
        $currentTime = time();
        $intervalStart = $currentTime - ($currentTime % 300);
        $existingStat = $this->bannerStatRepository->findOneByIntervalAndBanner($intervalStart, $bannerId);
        if ($existingStat) {
            $existingStat->setImpressions($existingStat->getImpressions() + 1);
            $this->bannerStatRepository->update($existingStat);
        } else {
            $newStat = new BannerStat();
            $newStat->setTimestamp($intervalStart);
            if ($type == 'impressions') {
                $newStat->setImpressions(1);
            }
            $newStat->setLocalBanner($banner);
            $this->bannerStatRepository->add($newStat);
        }
        return $this->htmlResponse();
    }

    public function getBannerAction(): \Psr\Http\Message\ResponseInterface
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $multilocationQB = $connectionPool->getQueryBuilderForTable('multilocations');

        $rootPid = $this->findRootPid($GLOBALS['TSFE']->page['uid']);
        $AllBanners = 0;
        $locationApiList = [];

        if($this->contentObject->data && !empty($this->contentObject->data['business_locations_banner'])){

            $selectedValues = explode(',', $this->contentObject->data['business_locations_banner']);

            foreach ($selectedValues as $uid) {
                $locationResult = $multilocationQB->select('dashboard_api_key')
                    ->from('multilocations')
                    ->where(
                        $multilocationQB->expr()
                            ->eq('uid', $uid)
                    )
                    ->executeQuery();
                $locationApi = $locationResult->fetchColumn();
                $locationApiList[] = $locationApi;
            }
        }

        if($this->contentObject->data && $this->contentObject->data['enable_slider'] == 1 ){
            $banner = $this->localBannerRepository->findAllBanners($rootPid,$locationApiList);
            $AllBanners = 1;
            $this->view->assign('slider', 1);
        }else{
            $banner = $this->localBannerRepository->findRandomBanner($rootPid,$locationApiList);
        }
        if($AllBanners){
            $tempBanner = [];
            foreach ($banner as $item){
                $item['banner_css'] = base64_encode($item['banner_css']);
                $item['banner_html'] = base64_encode($item['banner_html']);
                $item['banner_js'] = base64_encode($item['banner_js']);
                array_push($tempBanner,json_decode(json_encode($item)));
            }
            $this->view->assign('banner', json_decode(json_encode($tempBanner)));
            $this->view->assign('slider', 1);

        }else{
            $banner['banner_css'] = base64_encode($banner['banner_css']);
            $banner['banner_html'] = base64_encode($banner['banner_html']);
            $banner['banner_js'] = base64_encode($banner['banner_js']);

            $this->view->assign('banner', json_decode(json_encode($banner)));
        }

        return $this->htmlResponse();
    }

    protected function findRootPid(int $pageUid): int
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('pages');

        $row = $queryBuilder
            ->select('uid', 'pid', 'is_siteroot')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($pageUid, \PDO::PARAM_INT))
            )
            ->execute()
            ->fetch();

        if ($row && $row['is_siteroot']) {
            return (int)$row['uid'];
        } elseif ($row) {
            return $this->findRootPid((int)$row['pid']);
        }

        return 0;
    }

}

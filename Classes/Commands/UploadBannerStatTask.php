<?php

namespace GdprExtensionsCom\GdprExtensionsComBm\Commands;


use GdprExtensionsCom\GdprExtensionsComBm\Utility\UploadBannerStat;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class UploadBannerStatTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

    public function __construct()
    {
        parent::__construct();
    }

    public function execute()
    {
        $businessLogic = GeneralUtility::makeInstance(UploadBannerStat::class);
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);

        $logger = GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);

        $businessLogic->run($connectionPool,$logger, $siteFinder);
        return true;
    }
}

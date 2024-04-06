<?php

namespace GdprExtensionsCom\GdprExtensionsComBm\Commands;

use GdprExtensionsCom\GdprExtensionsComBm\Utility\SyncBanners;
use GdprExtensionsCom\GdprExtensionsComBm\Utility\Helper;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Scheduler\Task;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class SyncBannersTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

    public function __construct()
    {
        parent::__construct();
    }

    public function execute()
    {
        $businessLogic = GeneralUtility::makeInstance(SyncBanners::class);
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $logger = GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        $pathUtility = GeneralUtility::makeInstance(PathUtility::class);

        $businessLogic->run($connectionPool,$logger, $siteFinder, $pathUtility);
        return true;
    }
}

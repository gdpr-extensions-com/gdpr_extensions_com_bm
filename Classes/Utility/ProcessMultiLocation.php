<?php

namespace GdprExtensionsCom\GdprExtensionsComBm\Utility;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProcessMultiLocation
{

    public function __construct()
    {
    }

    public function getLocationsforRoodPid(array &$params)
    {
        $helper = GeneralUtility::makeInstance(Helper::class);
        $rootpid = $helper->getRootPage($params['row']['pid']);

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $reviewsLocationQB = $connectionPool->getQueryBuilderForTable(
            'multilocations'
        );

        $locationResult = $reviewsLocationQB->select('*')
            ->from('multilocations')
            ->where(
                $reviewsLocationQB->expr()
                    ->eq('pages', $reviewsLocationQB->createNamedParameter($rootpid)),
            )
            ->orderBy('name_of_location', 'DESC')

            ->executeQuery();

        while ($Location = $locationResult->fetchAssociative()) {

            if (strlen($Location['name_of_location']) < 1) {
                continue;
            }

            $params['items'][] = [$Location['name_of_location'], $Location['uid']];
        }
        return $params;
    }

}

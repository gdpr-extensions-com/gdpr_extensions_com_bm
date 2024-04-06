<?php

declare(strict_types=1);

namespace GdprExtensionsCom\GdprExtensionsComBm\Domain\Repository;


use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Connection;

/**
 * This file is part of the "gdpr_extensions_com_bm" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023
 */

/**
 * The repository for LocalBanners
 */
class LocalBannerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findRandomBanner($rootPid, $locationApiList)
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tx_gdprextensionscombm_domain_model_localbanner');

        $count = $queryBuilder
            ->count('*')
            ->from('tx_gdprextensionscombm_domain_model_localbanner')
            ->where(
                $queryBuilder->expr()->lte('valid_from', $queryBuilder->createNamedParameter(time(), \PDO::PARAM_INT)),
                $queryBuilder->expr()->gte('valid_to', $queryBuilder->createNamedParameter(time(), \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('root_pid', $queryBuilder->createNamedParameter($rootPid, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('is_archived', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('campaign_is_disabled', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)),
                $queryBuilder->expr()->in('dashboard_api_key', $queryBuilder->createNamedParameter($locationApiList, Connection::PARAM_STR_ARRAY))


            )
            ->execute()
            ->fetchOne();

        if ($count > 0) {
            $randomOffset = mt_rand(0, $count - 1);

            return $queryBuilder
                ->select('*')
                ->from('tx_gdprextensionscombm_domain_model_localbanner')
                ->where(
                    $queryBuilder->expr()->lte('valid_from', $queryBuilder->createNamedParameter(time(), \PDO::PARAM_INT)),
                    $queryBuilder->expr()->gte('valid_to', $queryBuilder->createNamedParameter(time(), \PDO::PARAM_INT)),
                    $queryBuilder->expr()->eq('root_pid', $queryBuilder->createNamedParameter($rootPid, \PDO::PARAM_INT)),
                    $queryBuilder->expr()->eq('is_archived', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)),
                    $queryBuilder->expr()->eq('campaign_is_disabled', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)),
                    $queryBuilder->expr()->in('dashboard_api_key', $queryBuilder->createNamedParameter($locationApiList, Connection::PARAM_STR_ARRAY))


                )
                ->setFirstResult($randomOffset)
                ->setMaxResults(1)
                ->execute()
                ->fetch();
        }

        return null;
    }

    public function findAllBanners($rootPid, $locationApiList)
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tx_gdprextensionscombm_domain_model_localbanner');

        $result = $queryBuilder
            ->select('*')
            ->from('tx_gdprextensionscombm_domain_model_localbanner')
            ->where(
                $queryBuilder->expr()->lte('valid_from', $queryBuilder->createNamedParameter(time(), \PDO::PARAM_INT)),
                $queryBuilder->expr()->gte('valid_to', $queryBuilder->createNamedParameter(time(), \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('root_pid', $queryBuilder->createNamedParameter($rootPid, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('is_archived', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('campaign_is_disabled', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)),
                $queryBuilder->expr()->in('dashboard_api_key', $queryBuilder->createNamedParameter($locationApiList, Connection::PARAM_STR_ARRAY))

            )
            ->executeQuery()
            ->fetchAllAssociative();

        return $result;
    }

}

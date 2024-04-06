<?php

declare(strict_types=1);

namespace GdprExtensionsCom\GdprExtensionsComBm\Domain\Repository;


/**
 * This file is part of the "gdpr_extensions_com_bm" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023
 */

/**
 * The repository for BannerStats
 */
class BannerStatRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findOneByIntervalAndBanner(int $intervalStart, int $bannerId)
    {
        $query = $this->createQuery();
        $constraint = $query->logicalAnd(
            $query->equals('timestamp', $intervalStart),
            $query->equals('localBanner', $bannerId)
        );
        $query->matching($constraint);
        return $query->execute()->getFirst();
    }
}

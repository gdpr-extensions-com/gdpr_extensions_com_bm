<?php

declare(strict_types=1);

namespace GdprExtensionsCom\GdprExtensionsComBm\Domain\Model;


/**
 * This file is part of the "gdpr_extensions_com_bm" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 
 */

/**
 * BannerStat
 */
class BannerStat extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * impressions
     *
     * @var int
     */
    protected $impressions = null;

    /**
     * timestamp
     *
     * @var int
     */
    protected $timestamp = null;

    /**
     * localBanner
     *
     * @var \GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\LocalBanner
     */
    protected $localBanner = null;

    /**
     * Returns the impressions
     *
     * @return int
     */
    public function getImpressions()
    {
        return $this->impressions;
    }

    /**
     * Sets the impressions
     *
     * @param int $impressions
     * @return void
     */
    public function setImpressions(int $impressions)
    {
        $this->impressions = $impressions;
    }

    /**
     * Returns the timestamp
     *
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Sets the timestamp
     *
     * @param int $timestamp
     * @return void
     */
    public function setTimestamp(int $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Returns the localBanner
     *
     * @return \GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\LocalBanner
     */
    public function getLocalBanner()
    {
        return $this->localBanner;
    }

    /**
     * Sets the localBanner
     *
     * @param \GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\LocalBanner $localBanner
     * @return void
     */
    public function setLocalBanner(\GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\LocalBanner $localBanner)
    {
        $this->localBanner = $localBanner;
    }
}

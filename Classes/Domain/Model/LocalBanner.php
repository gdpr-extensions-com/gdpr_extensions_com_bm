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
 * LocalBanner
 */
class LocalBanner extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * bannerId
     *
     * @var int
     */
    protected $bannerId = null;

    /**
     * bannerTitle
     *
     * @var string
     */
    protected $bannerTitle = null;

    /**
     * bannerHtml
     *
     * @var string
     */
    protected $bannerHtml = null;

    /**
     * bannerCss
     *
     * @var string
     */
    protected $bannerCss = null;

    /**
     * bannerJs
     *
     * @var string
     */
    protected $bannerJs = null;

    /**
     * validFrom
     *
     * @var int
     */
    protected $validFrom = null;

    /**
     * validTo
     *
     * @var int
     */
    protected $validTo = null;

    /**
     * rootPid
     *
     * @var string
     */
    protected $rootPid = null;

    /**
     * campaignId
     *
     * @var string
     */
    protected $campaignId = null;

    /**
     * campaignId
     *
     * @var string
     */
    protected $campaignTitle = null;


    /**
     * Returns the bannerId
     *
     * @return int
     */
    public function getBannerId()
    {
        return $this->bannerId;
    }

    /**
     * Sets the bannerId
     *
     * @param int $bannerId
     * @return void
     */
    public function setBannerId(int $bannerId)
    {
        $this->bannerId = $bannerId;
    }

    /**
     * Returns the bannerTitle
     *
     * @return string
     */
    public function getBannerTitle()
    {
        return $this->bannerTitle;
    }

    /**
     * Sets the bannerTitle
     *
     * @param string $bannerTitle
     * @return void
     */
    public function setBannerTitle(string $bannerTitle)
    {
        $this->bannerTitle = $bannerTitle;
    }

    /**
     * Returns the bannerHtml
     *
     * @return string
     */
    public function getBannerHtml()
    {
        return $this->bannerHtml;
    }

    /**
     * Sets the bannerHtml
     *
     * @param string $bannerHtml
     * @return void
     */
    public function setBannerHtml(string $bannerHtml)
    {
        $this->bannerHtml = $bannerHtml;
    }

    /**
     * Returns the bannerCss
     *
     * @return string
     */
    public function getBannerCss()
    {
        return $this->bannerCss;
    }

    /**
     * Sets the bannerCss
     *
     * @param string $bannerCss
     * @return void
     */
    public function setBannerCss(string $bannerCss)
    {
        $this->bannerCss = $bannerCss;
    }

    /**
     * Returns the bannerJs
     *
     * @return string
     */
    public function getBannerJs()
    {
        return $this->bannerJs;
    }

    /**
     * Sets the bannerJs
     *
     * @param string $bannerJs
     * @return void
     */
    public function setBannerJs(string $bannerJs)
    {
        $this->bannerJs = $bannerJs;
    }

    /**
     * Returns the validFrom
     *
     * @return int
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * Sets the validFrom
     *
     * @param int $validFrom
     * @return void
     */
    public function setValidFrom(int $validFrom)
    {
        $this->validFrom = $validFrom;
    }

    /**
     * Returns the validTo
     *
     * @return int
     */
    public function getValidTo()
    {
        return $this->validTo;
    }

    /**
     * Sets the validTo
     *
     * @param int $validTo
     * @return void
     */
    public function setValidTo(int $validTo)
    {
        $this->validTo = $validTo;
    }

    /**
     * Returns the rootPid
     *
     * @return string
     */
    public function getRootPid()
    {
        return $this->rootPid;
    }

    /**
     * Sets the rootPid
     *
     * @param string $rootPid
     * @return void
     */
    public function setRootPid(string $rootPid)
    {
        $this->rootPid = $rootPid;
    }

    /**
     * Returns the campaignId
     *
     * @return string
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

    /**
     * Sets the campaignId
     *
     * @param string $campaignId
     * @return void
     */
    public function setCampaignId(string $campaignId)
    {
        $this->campaignId = $campaignId;
    }

    /**
     * @return string|null
     */
    public function getCampaignTitle(): ?string
    {
        return $this->campaignTitle;
    }

    /**
     * @param string|null $campaignTitle
     */
    public function setCampaignTitle(?string $campaignTitle): void
    {
        $this->campaignTitle = $campaignTitle;
    }
}

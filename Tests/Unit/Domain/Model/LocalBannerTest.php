<?php

declare(strict_types=1);

namespace GdprExtensionsCom\GdprExtensionsComBm\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class LocalBannerTest extends UnitTestCase
{
    /**
     * @var \GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\LocalBanner|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\LocalBanner::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getBannerIdReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getBannerId()
        );
    }

    /**
     * @test
     */
    public function setBannerIdForIntSetsBannerId(): void
    {
        $this->subject->setBannerId(12);

        self::assertEquals(12, $this->subject->_get('bannerId'));
    }

    /**
     * @test
     */
    public function getBannerTitleReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBannerTitle()
        );
    }

    /**
     * @test
     */
    public function setBannerTitleForStringSetsBannerTitle(): void
    {
        $this->subject->setBannerTitle('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('bannerTitle'));
    }

    /**
     * @test
     */
    public function getBannerHtmlReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBannerHtml()
        );
    }

    /**
     * @test
     */
    public function setBannerHtmlForStringSetsBannerHtml(): void
    {
        $this->subject->setBannerHtml('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('bannerHtml'));
    }

    /**
     * @test
     */
    public function getBannerCssReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBannerCss()
        );
    }

    /**
     * @test
     */
    public function setBannerCssForStringSetsBannerCss(): void
    {
        $this->subject->setBannerCss('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('bannerCss'));
    }

    /**
     * @test
     */
    public function getBannerJsReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBannerJs()
        );
    }

    /**
     * @test
     */
    public function setBannerJsForStringSetsBannerJs(): void
    {
        $this->subject->setBannerJs('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('bannerJs'));
    }

    /**
     * @test
     */
    public function getValidFromReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getValidFrom()
        );
    }

    /**
     * @test
     */
    public function setValidFromForIntSetsValidFrom(): void
    {
        $this->subject->setValidFrom(12);

        self::assertEquals(12, $this->subject->_get('validFrom'));
    }

    /**
     * @test
     */
    public function getValidToReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getValidTo()
        );
    }

    /**
     * @test
     */
    public function setValidToForIntSetsValidTo(): void
    {
        $this->subject->setValidTo(12);

        self::assertEquals(12, $this->subject->_get('validTo'));
    }

    /**
     * @test
     */
    public function getRootPidReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getRootPid()
        );
    }

    /**
     * @test
     */
    public function setRootPidForStringSetsRootPid(): void
    {
        $this->subject->setRootPid('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('rootPid'));
    }

    /**
     * @test
     */
    public function getCampaignIdReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCampaignId()
        );
    }

    /**
     * @test
     */
    public function setCampaignIdForStringSetsCampaignId(): void
    {
        $this->subject->setCampaignId('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('campaignId'));
    }
}

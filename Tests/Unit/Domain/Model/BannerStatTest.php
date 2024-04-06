<?php

declare(strict_types=1);

namespace GdprExtensionsCom\GdprExtensionsComBm\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class BannerStatTest extends UnitTestCase
{
    /**
     * @var \GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\BannerStat|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\BannerStat::class,
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
    public function getImpressionsReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getImpressions()
        );
    }

    /**
     * @test
     */
    public function setImpressionsForIntSetsImpressions(): void
    {
        $this->subject->setImpressions(12);

        self::assertEquals(12, $this->subject->_get('impressions'));
    }

    /**
     * @test
     */
    public function getTimestampReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getTimestamp()
        );
    }

    /**
     * @test
     */
    public function setTimestampForIntSetsTimestamp(): void
    {
        $this->subject->setTimestamp(12);

        self::assertEquals(12, $this->subject->_get('timestamp'));
    }

    /**
     * @test
     */
    public function getLocalBannerReturnsInitialValueForLocalBanner(): void
    {
        self::assertEquals(
            null,
            $this->subject->getLocalBanner()
        );
    }

    /**
     * @test
     */
    public function setLocalBannerForLocalBannerSetsLocalBanner(): void
    {
        $localBannerFixture = new \GdprExtensionsCom\GdprExtensionsComBm\Domain\Model\LocalBanner();
        $this->subject->setLocalBanner($localBannerFixture);

        self::assertEquals($localBannerFixture, $this->subject->_get('localBanner'));
    }
}

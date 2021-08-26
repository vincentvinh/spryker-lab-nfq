<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\BrandStorage\Communication\Plugin\Event\Listener;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use Orm\Zed\BrandStorage\Persistence\SpyBrandStorageQuery;
use Pyz\Zed\Brand\Dependency\BrandEvents;
use Pyz\Zed\BrandStorage\Communication\Plugin\Event\Listener\BrandStoragePublishListener;
use Pyz\Zed\BrandStorage\Communication\Plugin\Event\Listener\BrandStorageUnpublishListener;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group BrandStorage
 * @group Communication
 * @group Plugin
 * @group Event
 * @group Listener
 * @group BrandStorageListenerTest
 * Add your own group annotations below this line
 */
class BrandStorageListenerTest extends Unit
{
    /**
     * @var \PyzTest\Zed\BrandStorage\BrandStorageCommunicationTester
     */
    protected $tester;

    /**
     * @var \Generated\Shared\Transfer\BrandTransfer
     */
    protected $brandTransfer;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpData();
    }

    /**
     * @return array $eventTransfers
     */
    public function testBrandPublishStorageListenerStoreData(): array
    {
        $brandStoragePublishStorageListener = new BrandStoragePublishListener();
        $brandStoragePublishStorageListener->setFacade($this->tester->getFacade());

        $eventTransfers = [
            (new EventEntityTransfer())->setId($this->brandTransfer->getIdBrand()),
        ];

        $brandStoragePublishStorageListener->handleBulk($eventTransfers, BrandEvents::BRAND_PUBLISH);

        $this->assertBrandStorage();

        return $eventTransfers;
    }


    /**
     * @param array $eventTransfers
     * @depends testBrandPublishStorageListenerStoreData
     */
    public function testBrandUnPublishStorageListenerStoreData(array $eventTransfers): void
    {
        $brandStorageUnpublishStorageListener = new BrandStorageUnpublishListener();
        $brandStorageUnpublishStorageListener->setFacade($this->tester->getFacade());

        $brandStorageUnpublishStorageListener->handleBulk($eventTransfers, BrandEvents::BRAND_UNPUBLISH);

        $spyBrandStorage = SpyBrandStorageQuery::create()->filterByFkBrand_In([$this->brandTransfer->getIdBrand()])->find();

        $this->assertEmpty($spyBrandStorage->toArray());
    }

    /**
     * @return void
     */
    protected function assertBrandStorage()
    {
        $spyBrandStorage = SpyBrandStorageQuery::create()->filterByFkBrand_In([$this->brandTransfer->getIdBrand()])->find();

        $this->assertNotEmpty($spyBrandStorage->toArray());
    }

    /**
     * @return void
     */
    protected function setUpData(): void
    {
        $this->brandTransfer = $this->tester->haveBrand();
    }
}

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
     * @return void
     */
    public function testBrandPublishStorageListenerStoreData(): void
    {
        $brandStoragePublishStorageListener = new BrandStoragePublishListener();
        $brandStoragePublishStorageListener->setFacade($this->tester->getFacade());

        $eventTransfers = [
            (new EventEntityTransfer())->setId($this->brandTransfer->getIdBrand()),
        ];

        $brandStoragePublishStorageListener->handleBulk($eventTransfers, BrandEvents::BRAND_PUBLISH);

        $this->assertBrandStorage();
    }

    /**
     * @return void
     */
    protected function assertBrandStorage()
    {
        $spyBrandStorage = SpyBrandStorageQuery::create()->filterByFkBrand_In([$this->brandTransfer->getIdBrand()])->find();

        $this->assertNotNull($spyBrandStorage);
    }

    /**
     * @return void
     */
    protected function setUpData(): void
    {
        $this->brandTransfer = $this->tester->haveBrand();
    }
}

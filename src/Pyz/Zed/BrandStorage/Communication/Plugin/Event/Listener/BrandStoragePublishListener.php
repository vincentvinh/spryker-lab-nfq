<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\BrandStorage\Communication\Plugin\Event\Listener;

use Pyz\Zed\Brand\Dependency\BrandEvents;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

/**
 * @method \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\BrandStorage\Communication\BrandStorageCommunicationFactory getFactory()
 * @method \Pyz\Zed\BrandStorage\Business\BrandStorageFacade getFacade()
 * @method \Pyz\Zed\BrandStorage\BrandStorageConfig getConfig()
 */
class BrandStoragePublishListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    use TransactionTrait;

    /**
     * @param array $eventTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventTransfers, $eventName)
    {
        $brandIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferIds($eventTransfers);

        $this->getFacade()->publish($brandIds);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            BrandEvents::ENTITY_SPY_BRAND_CREATE,
            BrandEvents::ENTITY_SPY_BRAND_UPDATE,
        ];
    }
}

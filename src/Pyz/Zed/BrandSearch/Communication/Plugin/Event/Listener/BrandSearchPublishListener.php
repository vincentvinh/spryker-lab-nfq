<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\BrandSearch\Communication\Plugin\Event\Listener;

use Pyz\Zed\Brand\Dependency\BrandEvents;
use Pyz\Zed\ProductBrand\Dependency\ProductBrandEvents;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

/**
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\BrandSearch\Communication\BrandSearchCommunicationFactory getFactory()
 * @method \Pyz\Zed\BrandSearch\Business\BrandSearchFacade getFacade()
 * @method \Pyz\Zed\BrandSearch\BrandSearchConfig getConfig()
 */
class BrandSearchPublishListener extends AbstractPlugin implements EventBulkHandlerInterface
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
        if ($eventName == BrandEvents::ENTITY_SPY_BRAND_CREATE || $eventName == BrandEvents::ENTITY_SPY_BRAND_UPDATE) {
            $brandIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferIds($eventTransfers);
        } else {
            $brandIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferForeignKeys($eventTransfers, 'spy_product_brand.fk_brand');
        }

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
            ProductBrandEvents::ENTITY_SPY_PRODUCT_BRAND_UPDATE,
            ProductBrandEvents::ENTITY_SPY_PRODUCT_BRAND_CREATE,
        ];
    }
}

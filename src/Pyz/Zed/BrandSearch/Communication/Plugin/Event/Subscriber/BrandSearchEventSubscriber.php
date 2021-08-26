<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\BrandSearch\Communication\Plugin\Event\Subscriber;

use Pyz\Zed\Brand\Dependency\BrandEvents;
use Pyz\Zed\BrandSearch\Communication\Plugin\Event\Listener\BrandSearchPublishListener;
use Pyz\Zed\BrandSearch\Communication\Plugin\Event\Listener\BrandSearchUnpublishListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\BrandSearch\Business\BrandSearchFacadeInterface getFacade()
 * @method \Pyz\Zed\BrandSearch\BrandSearchConfig getConfig()
 * @method \Pyz\Zed\BrandSearch\Communication\BrandSearchCommunicationFactory getFactory()
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainerInterface getQueryContainer()
 */
class BrandSearchEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection = $this->addBrandCreateSearchListener($eventCollection);
        $eventCollection = $this->addBrandUpdateSearchListener($eventCollection);
        $eventCollection = $this->addBrandDeleteSearchListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addBrandCreateSearchListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(BrandEvents::ENTITY_SPY_BRAND_CREATE, new BrandSearchPublishListener());

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addBrandUpdateSearchListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(BrandEvents::ENTITY_SPY_BRAND_UPDATE, new BrandSearchPublishListener());

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addBrandDeleteSearchListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(BrandEvents::ENTITY_SPY_BRAND_DELETE, new BrandSearchUnpublishListener());

        return $eventCollection;
    }
}

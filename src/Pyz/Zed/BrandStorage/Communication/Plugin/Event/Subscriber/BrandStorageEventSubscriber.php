<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\BrandStorage\Communication\Plugin\Event\Subscriber;

use Pyz\Zed\Brand\Dependency\BrandEvents;
use Pyz\Zed\BrandStorage\Communication\Plugin\Event\Listener\BrandStoragePublishListener;
use Pyz\Zed\BrandStorage\Communication\Plugin\Event\Listener\BrandStorageUnpublishListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\BrandStorage\Business\BrandStorageFacadeInterface getFacade()
 * @method \Pyz\Zed\BrandStorage\BrandStorageConfig getConfig()
 * @method \Pyz\Zed\BrandStorage\Communication\BrandStorageCommunicationFactory getFactory()
 * @method \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainerInterface getQueryContainer()
 */
class BrandStorageEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection = $this->addBrandCreateStorageListener($eventCollection);
        $eventCollection = $this->addBrandUpdateStorageListener($eventCollection);
        $eventCollection = $this->addBrandDeleteStorageListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addBrandCreateStorageListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(BrandEvents::ENTITY_SPY_BRAND_CREATE, new BrandStoragePublishListener());

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addBrandUpdateStorageListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(BrandEvents::ENTITY_SPY_BRAND_UPDATE, new BrandStoragePublishListener());

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addBrandDeleteStorageListener(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(BrandEvents::ENTITY_SPY_BRAND_DELETE, new BrandStorageUnpublishListener());

        return $eventCollection;
    }
}

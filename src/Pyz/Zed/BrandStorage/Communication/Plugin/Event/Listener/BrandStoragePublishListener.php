<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\BrandStorage\Communication\Plugin\Event\Listener;

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
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function handleBulk(array $eventTransfers, $eventName)
    {
        $brandIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferIds($eventTransfers);

        $this->getFacade()->publish($brandIds);
    }
}

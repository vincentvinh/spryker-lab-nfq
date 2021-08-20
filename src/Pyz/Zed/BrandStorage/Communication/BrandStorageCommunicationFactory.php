<?php

namespace Pyz\Zed\BrandStorage\Communication;

use Pyz\Zed\BrandStorage\BrandStorageDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainer getQueryContainer()
 * @method \Pyz\Zed\BrandStorage\BrandStorageConfig getConfig()
 */
class BrandStorageCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return mixed
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getEventBehaviorFacade()
    {
        return $this->getProvidedDependency(BrandStorageDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }
}

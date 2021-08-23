<?php

namespace Pyz\Zed\BrandStorage\Communication;

use Pyz\Zed\BrandStorage\BrandStorageDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainer getQueryContainer()
 * @method \Pyz\Zed\BrandStorage\BrandStorageConfig getConfig()
 * @method \Pyz\Zed\BrandStorage\Business\BrandStorageFacadeInterface getFacade()
 */
class BrandStorageCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return mixed
     */
    public function getEventBehaviorFacade()
    {
        return $this->getProvidedDependency(BrandStorageDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }
}

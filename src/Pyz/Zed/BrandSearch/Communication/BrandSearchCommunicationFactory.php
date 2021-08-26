<?php

namespace Pyz\Zed\BrandSearch\Communication;

use Pyz\Zed\BrandStorage\BrandStorageDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainer getQueryContainer()
 * @method \Pyz\Zed\BrandSearch\BrandSearchConfig getConfig()
 */
class BrandSearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return mixed
     */
    public function getEventBehaviorFacade()
    {
        return $this->getProvidedDependency(BrandStorageDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }
}

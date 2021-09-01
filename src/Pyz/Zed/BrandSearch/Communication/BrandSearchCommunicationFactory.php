<?php

namespace Pyz\Zed\BrandSearch\Communication;

use Pyz\Zed\BrandSearch\BrandSearchDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainer getQueryContainer()
 * @method \Pyz\Zed\BrandSearch\BrandSearchConfig getConfig()
 * @method \Pyz\Zed\BrandSearch\Business\BrandSearchFacadeInterface getFacade()
 */
class BrandSearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return mixed
     */
    public function getEventBehaviorFacade()
    {
        return $this->getProvidedDependency(BrandSearchDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }

    /**
     * @return mixed
     */
    public function getProductBrandQueryContainer()
    {
        return $this->getProvidedDependency(BrandSearchDependencyProvider::QUERY_CONTAINER_PRODUCT_BRAND);
    }
}

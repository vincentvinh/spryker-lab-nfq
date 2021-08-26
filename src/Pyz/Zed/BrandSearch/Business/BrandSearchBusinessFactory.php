<?php

namespace Pyz\Zed\BrandSearch\Business;

use Pyz\Zed\BrandSearch\BrandSearchDependencyProvider;
use Pyz\Zed\BrandSearch\Business\Writer\BrandSearchWriter;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\BrandSearch\BrandSearchConfig getConfig()
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainer getQueryContainer()
 */
class BrandSearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return BrandSearchWriter
     */
    public function createBrandSearchWriter(): BrandSearchWriter
    {
        return new BrandSearchWriter(
            $this->getQueryContainer(),
            $this->getStore()
        );
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->getProvidedDependency(BrandSearchDependencyProvider::STORE);
    }
}

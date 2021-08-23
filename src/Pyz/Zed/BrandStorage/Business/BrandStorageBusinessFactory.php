<?php

namespace Pyz\Zed\BrandStorage\Business;

use Pyz\Zed\BrandStorage\BrandStorageDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\BrandStorage\BrandStorageConfig getConfig()
 * @method \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainer getQueryContainer()
 */
class BrandStorageBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\BrandStorage\Business\BrandStorageWrite
     */
    public function createBrandStorageWrite(): BrandStorageWrite
    {
        return new BrandStorageWrite(
            $this->getQueryContainer(),
            $this->getStore()
        );
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->getProvidedDependency(BrandStorageDependencyProvider::STORE);
    }
}

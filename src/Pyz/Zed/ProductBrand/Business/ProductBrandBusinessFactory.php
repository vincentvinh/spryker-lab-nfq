<?php

namespace Pyz\Zed\ProductBrand\Business;

use Pyz\Zed\ProductBrand\Business\Reader\BrandReader;
use Pyz\Zed\ProductBrand\Business\Reader\BrandReaderInterface;
use Pyz\Zed\ProductBrand\Business\Writer\ProductBrandManager;
use Pyz\Zed\ProductBrand\ProductBrandDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\ProductBrand\ProductBrandConfig getConfig()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandRepository getRepository()()
 */
class ProductBrandBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\ProductBrand\Business\Writer\ProductBrandManagerInterface
     */
    public function createProductBrandWriter()
    {
        return new ProductBrandManager(
            $this->getQueryContainer(),
            $this->getBrandFacade(),
            $this->getProductFacade(),
            $this->getEventFacade()
        );
    }

    /**
     * @return \Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected function getProductFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \Spryker\Zed\Event\Business\EventFacadeInterface
     */
    protected function getEventFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_EVENT);
    }

    /**
     * @return \Pyz\Zed\Brand\Business\BrandFacadeInterface
     */
    protected function getBrandFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_BRAND);
    }

    /**
     * @return \Pyz\Zed\ProductBrand\Business\Reader\BrandReaderInterface
     */
    public function createBrandReader(): BrandReaderInterface
    {
        return new BrandReader(
            $this->getRepository(),
            $this->getBrandFacade()
        );
    }
}

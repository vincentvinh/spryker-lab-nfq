<?php

namespace Pyz\Zed\ProductBrand\Business;

use Pyz\Zed\ProductBrand\Business\Writer\ProductBrandManagerInterface;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainer;
use Pyz\Zed\ProductBrand\ProductBrandConfig;
use Pyz\Zed\ProductBrand\ProductBrandDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method ProductBrandConfig getConfig()
 * @method ProductBrandQueryContainer getQueryContainer()
 */
class ProductBrandBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return ProductBrandManagerInterface
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
     * @return ProductBrandToProductInterface
     */
    protected function getProductFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return ProductBrandToEventInterface
     */
    protected function getEventFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_EVENT);
    }

    /**
     * @return ProductBrandToBrandInterface
     */
    protected function getBrandFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_BRAND);
    }

    /**
     * @return BrandReaderInterface
     */
    public function createBrandReader(): BrandReaderInterface
    {
        return new BrandReader(
            $this->getRepository(),
            $this->getBrandFacade()
        );
    }

}

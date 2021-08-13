<?php

namespace Pyz\Zed\ProductBrand\Business;

use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use Pyz\Zed\ProductBrand\Business\Reader\BrandReader;
use Pyz\Zed\ProductBrand\Business\Reader\BrandReaderInterface;
use Pyz\Zed\ProductBrand\Business\Writer\ProductBrandManager;
use Pyz\Zed\ProductBrand\Business\Writer\ProductBrandManagerInterface;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainer;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandRepository;
use Pyz\Zed\ProductBrand\ProductBrandConfig;
use Pyz\Zed\ProductBrand\ProductBrandDependencyProvider;
use Spryker\Zed\Event\Business\EventFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

/**
 * @method ProductBrandConfig getConfig()
 * @method ProductBrandQueryContainer getQueryContainer()
 * @method ProductBrandRepository getRepository()()
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
     * @return ProductFacadeInterface
     */
    protected function getProductFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return EventFacadeInterface
     */
    protected function getEventFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_EVENT);
    }

    /**
     * @return BrandFacadeInterface
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

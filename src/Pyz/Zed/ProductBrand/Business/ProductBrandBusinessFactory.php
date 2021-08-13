<?php

namespace Pyz\Zed\ProductBrand\Business;

use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainer;
use Pyz\Zed\ProductBrand\ProductBrandConfig;
use Pyz\Zed\ProductBrand\ProductBrandDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ProductCategory\Business\Manager\ProductBrandManager;
use Spryker\Zed\ProductCategory\Business\Manager\ProductCategoryManagerInterface;
use Spryker\Zed\ProductCategory\Business\Model\BrandReader;
use Spryker\Zed\ProductCategory\Business\Model\CategoryReaderInterface;
use Spryker\Zed\ProductCategory\Dependency\Facade\ProductCategoryToCategoryInterface;
use Spryker\Zed\ProductCategory\Dependency\Facade\ProductCategoryToEventInterface;
use Spryker\Zed\ProductCategory\Dependency\Facade\ProductCategoryToProductInterface;
use Spryker\Zed\ProductCategory\ProductCategoryDependencyProvider;

/**
 * @method ProductBrandConfig getConfig()
 * @method ProductBrandQueryContainer getQueryContainer()
 */
class ProductBrandBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return ProductCategoryManagerInterface
     */
    public function createProductBrandWriter()
    {
        return new ProductBrandManager(
            $this->getQueryContainer(),
            $this->getCategoryFacade(),
            $this->getProductFacade(),
            $this->getEventFacade()
        );
    }

    /**
     * @return ProductCategoryToProductInterface
     */
    protected function getProductFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return ProductCategoryToEventInterface
     */
    protected function getEventFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_EVENT);
    }

    /**
     * @return ProductCategoryToCategoryInterface
     */
    protected function getBrandFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_BRAND);
    }

    /**
     * @return CategoryReaderInterface
     */
    public function createBrandReader(): CategoryReaderInterface
    {
        return new BrandReader(
            $this->getRepository(),
            $this->getBrandFacade()
        );
    }

}

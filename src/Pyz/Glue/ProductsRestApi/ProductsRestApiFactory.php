<?php

namespace Pyz\Glue\ProductsRestApi;

use Pyz\Glue\ProductsRestApi\Processor\Mapper\AbstractProductsResourceMapper;
use Spryker\Glue\ProductsRestApi\Processor\Mapper\AbstractProductsResourceMapperInterface;
use Spryker\Glue\ProductsRestApi\ProductsRestApiFactory as SprykerProductsRestApiFactory;

class ProductsRestApiFactory extends SprykerProductsRestApiFactory
{
    /**
     * @return \Spryker\Glue\ProductsRestApi\Processor\Mapper\AbstractProductsResourceMapperInterface
     */
    public function createAbstractProductsResourceMapper(): AbstractProductsResourceMapperInterface
    {
        return new AbstractProductsResourceMapper($this->getBrandQueryContainer());
    }

    /**
     * @return mixed
     */
    public function getBrandQueryContainer()
    {
        return $this->getProvidedDependency(ProductsRestApiDependencyProvider::BRAND_QUERY_CONTAINER);
    }
}

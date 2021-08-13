<?php

namespace Pyz\Zed\ProductBrand\Persistence;

use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\ProductBrand\Persistence\SpyProductBrandQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\ProductBrand\Persistence\Mapper\BrandMapperInterface;

/**
 * @method \Pyz\Zed\ProductBrand\ProductBrandConfig getConfig()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainer getQueryContainer()
 */
class ProductBrandPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ProductBrand\Persistence\SpyProductBrandQuery
     */
    public function createProductBrandQuery()
    {
        return SpyProductBrandQuery::create();
    }

    /**
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function createProductAbstractQuery()
    {
        return SpyProductAbstractQuery::create();
    }

    /**
     * @return \Spryker\Zed\ProductBrand\Persistence\Mapper\BrandMapperInterface
     */
    public function createBrandMapper(): BrandMapperInterface
    {
        return new BrandMapper();
    }
}

<?php

namespace Pyz\Zed\ProductBrand\Persistence;

use Orm\Zed\Brand\Persistence\SpyProductBrandQuery;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Pyz\Zed\ProductBrand\Persistence\Mapper\BrandMapper;
use Pyz\Zed\ProductBrand\Persistence\Mapper\BrandMapperInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\ProductBrand\ProductBrandConfig getConfig()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface getRepository()
 */
class ProductBrandPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
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
     * @return \Pyz\Zed\ProductBrand\Persistence\Mapper\BrandMapperInterface
     */
    public function createBrandMapper(): BrandMapperInterface
    {
        return new BrandMapper();
    }
}

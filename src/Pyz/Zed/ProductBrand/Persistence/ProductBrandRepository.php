<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Persistence;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Orm\Zed\Brand\Persistence\Map\SpyBrandAttributeTableMap;
use Orm\Zed\Brand\Persistence\Map\SpyProductBrandTableMap;
use Orm\Zed\Brand\Persistence\SpyProductBrandQuery;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

/**
 * @method ProductBrandPersistenceFactory getFactory()
 */
class ProductBrandRepository extends AbstractRepository implements ProductBrandRepositoryInterface
{
    protected const TABLE_JOIN_CATEGORY = 'Brand';

    /**
     * @param int $idProductAbstract
     * @param int $idLocale
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getBrandTransferCollectionByIdProductAbstract(int $idProductAbstract, int $idLocale): BrandCollectionTransfer
    {
        $spyBrandCollection = $this->queryCategoriesByIdProductAbstract($idProductAbstract, $idLocale)->find();

        return $this->getFactory()
            ->createBrandMapper()
            ->mapBrandCollection($spyBrandCollection, new BrandCollectionTransfer());
    }

    /**
     * @param int $idProductAbstract
     * @param int $idLocale
     *
     */
    protected function queryCategoriesByIdProductAbstract(int $idProductAbstract, int $idLocale): SpyProductBrandQuery
    {
        return $this->getFactory()->createProductBrandQuery()
            ->innerJoinWithSpyBrand()
            ->useSpyBrandQuery()
            ->joinAttribute()
            ->withColumn(SpyBrandAttributeTableMap::COL_NAME, 'name')
            ->addAnd(
                SpyBrandAttributeTableMap::COL_FK_LOCALE,
                $idLocale,
                Criteria::EQUAL
            )
            ->addAscendingOrderByColumn(SpyBrandAttributeTableMap::COL_NAME)
            ->endUse()
            ->addAnd(
                SpyProductBrandTableMap::COL_FK_PRODUCT_ABSTRACT,
                $idProductAbstract,
                Criteria::EQUAL
            )
            ->groupByFkBrand()
            ->groupBy(SpyBrandAttributeTableMap::COL_NAME);
    }

    /**
     * @module Product
     *
     * @param int[] $brandIds
     *
     * @return int[]
     */
    public function getProductConcreteIdsByBrandIds(array $brandIds): array
    {
        return $this->getFactory()
            ->createProductBrandQuery()
            ->select(SpyProductTableMap::COL_ID_PRODUCT)
            ->filterByFkBrand_In($brandIds)
            ->useSpyProductAbstractQuery()
                ->innerJoinSpyProduct()
            ->endUse()
            ->find()
            ->toArray();
    }
}

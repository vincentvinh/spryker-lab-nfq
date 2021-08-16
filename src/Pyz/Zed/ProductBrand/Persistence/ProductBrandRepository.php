<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Persistence;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Orm\Zed\Brand\Persistence\Map\SpyBrandAttributeTableMap;
use Orm\Zed\Brand\Persistence\Map\SpyBrandTableMap;
use Orm\Zed\Brand\Persistence\Map\SpyProductBrandTableMap;
use Orm\Zed\Brand\Persistence\SpyProductBrandQuery;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

/**
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandPersistenceFactory getFactory()
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
        $spyProductBrandCollection = $this->queryBrandsByIdProductAbstract($idProductAbstract, $idLocale)->find();

        return $this->getFactory()
            ->createBrandMapper()
            ->mapBrandCollection($spyProductBrandCollection, new BrandCollectionTransfer());
    }

    /**
     * @param int $idProductAbstract
     * @param int $idLocale
     *
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
     */
    protected function queryBrandsByIdProductAbstract(int $idProductAbstract, int $idLocale): SpyProductBrandQuery
    {
        return $this->getFactory()->createProductBrandQuery()
            ->innerJoinWithSpyBrand()
            ->useSpyBrandQuery()
            ->joinAttribute()
            ->withColumn(SpyBrandTableMap::COL_NAME, 'name')
            ->addAnd(
                SpyBrandAttributeTableMap::COL_FK_LOCALE,
                $idLocale,
                Criteria::EQUAL
            )
            ->addAscendingOrderByColumn(SpyBrandTableMap::COL_NAME)
            ->endUse()
            ->addAnd(
                SpyProductBrandTableMap::COL_FK_PRODUCT_ABSTRACT,
                $idProductAbstract,
                Criteria::EQUAL
            )
            ->groupByFkBrand()
            ->groupBy(SpyBrandTableMap::COL_NAME);
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

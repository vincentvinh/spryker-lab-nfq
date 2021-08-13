<?php

namespace Pyz\Zed\ProductBrand\Persistence;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Brand\Persistence\Map\SpyProductBrandTableMap;
use Orm\Zed\Brand\Persistence\SpyProductBrandQuery;
use Orm\Zed\Locale\Persistence\Map\SpyLocaleTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractLocalizedAttributesTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method ProductBrandPersistenceFactory getFactory()
 */
class ProductBrandQueryContainer extends AbstractQueryContainer implements ProductBrandQueryContainerInterface
{
    public const COL_BRAND_NAME = 'brand_name';
    public const VIRTUAL_COLUMN_ID_BRAND_NODE = 'id_brand_node';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandMappings()
    {
        return $this->getFactory()->createProductBrandQuery();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idBrand
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandMappingsByBrandId($idBrand)
    {
        return $this->getFactory()
            ->createProductBrandQuery()
            ->filterByFkBrand($idBrand);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idBrand
     * @param int $idProductAbstract
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandMappingByIds($idBrand, $idProductAbstract)
    {
        $query = $this->queryProductBrandMappings();
        $query
            ->filterByFkProductAbstract($idProductAbstract)
            ->filterByFkBrand($idBrand);

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return SpyProductBrandQuery
     */
    public function queryLocalizedProductBrandMappingByIdProduct($idProductAbstract)
    {
        $query = $this->queryProductBrandMappings();
        $query->filterByFkProductAbstract($idProductAbstract);

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @param int $idBrand
     * @param LocaleTransfer $locale
     *
     * @return SpyProductBrandQuery
     *@api
     *
     */
    public function queryProductsByBrandId(int $idBrand, LocaleTransfer $locale)
    {
        return $this->queryProductBrandMappings()
            ->innerJoinSpyProductAbstract()
            ->addJoin(
                SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
                SpyProductAbstractLocalizedAttributesTableMap::COL_FK_PRODUCT_ABSTRACT,
                Criteria::INNER_JOIN
            )
            ->addJoin(
                SpyProductAbstractLocalizedAttributesTableMap::COL_FK_LOCALE,
                SpyLocaleTableMap::COL_ID_LOCALE,
                Criteria::INNER_JOIN
            )
            ->addAnd(
                SpyLocaleTableMap::COL_ID_LOCALE,
                $locale->getIdLocale(),
                Criteria::EQUAL
            )
            ->addAnd(
                SpyLocaleTableMap::COL_IS_ACTIVE,
                true,
                Criteria::EQUAL
            )
            ->withColumn(
                SpyProductAbstractLocalizedAttributesTableMap::COL_NAME,
                'name'
            )
            ->withColumn(
                SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
                'id_product_abstract'
            )
            ->withColumn(
                SpyProductAbstractTableMap::COL_ATTRIBUTES,
                'abstract_attributes'
            )
            ->withColumn(
                SpyProductAbstractLocalizedAttributesTableMap::COL_ATTRIBUTES,
                'abstract_localized_attributes'
            )
            ->withColumn(
                SpyProductAbstractTableMap::COL_SKU,
                'sku'
            )
            ->withColumn(
                SpyProductBrandTableMap::COL_ID_PRODUCT_BRAND,
                'id_product_brand'
            )
            ->filterByFkBrand($idBrand)
            ->orderByFkProductAbstract();
    }

    /**
     * {@inheritDoc}
     *
     * @param string|null $term
     * @param int $idBrand
     * @param LocaleTransfer $localeTransfer
     *
     * @return SpyProductAbstractQuery
     *@api
     *
     */
    public function queryProductsAbstractBySearchTermForAssignment($term, $idBrand, LocaleTransfer $localeTransfer)
    {
        $query = $this->queryProductsAbstractBySearchTerm($term, $localeTransfer);
        $query->addJoin(
            [SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT, $idBrand],
            [SpyProductBrandTableMap::COL_FK_PRODUCT_ABSTRACT, SpyProductBrandTableMap::COL_FK_BRAND],
            Criteria::LEFT_JOIN
        )
            ->addAnd(
                SpyProductBrandTableMap::COL_FK_BRAND,
                null,
                Criteria::ISNULL
            );

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @param string|null $term
     * @param LocaleTransfer $locale
     *
     * @return SpyProductAbstractQuery
     *@api
     *
     */
    public function queryProductsAbstractBySearchTerm($term, LocaleTransfer $locale)
    {
        $query = $this->getFactory()->createProductAbstractQuery();

        $query->addJoin(
            SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
            SpyProductAbstractLocalizedAttributesTableMap::COL_FK_PRODUCT_ABSTRACT,
            Criteria::INNER_JOIN
        )
            ->addJoin(
                SpyProductAbstractLocalizedAttributesTableMap::COL_FK_LOCALE,
                SpyLocaleTableMap::COL_ID_LOCALE,
                Criteria::INNER_JOIN
            )
            ->addAnd(
                SpyLocaleTableMap::COL_ID_LOCALE,
                $locale->getIdLocale(),
                Criteria::EQUAL
            )
            ->addAnd(
                SpyLocaleTableMap::COL_IS_ACTIVE,
                true,
                Criteria::EQUAL
            )
            ->withColumn(
                SpyProductAbstractLocalizedAttributesTableMap::COL_NAME,
                'name'
            )
            ->withColumn(
                SpyProductAbstractTableMap::COL_ATTRIBUTES,
                'abstract_attributes'
            )
            ->withColumn(
                SpyProductAbstractLocalizedAttributesTableMap::COL_ATTRIBUTES,
                'abstract_localized_attributes'
            );

        $query->groupByAttributes();
        $query->groupByIdProductAbstract();

        if (trim($term) !== '') {
            $term = '%' . mb_strtoupper($term) . '%';

            $query->where('UPPER(' . SpyProductAbstractTableMap::COL_SKU . ') LIKE ?', $term, PDO::PARAM_STR)
                ->_or()
                ->where('UPPER(' . SpyProductAbstractLocalizedAttributesTableMap::COL_NAME . ') LIKE ?', $term, PDO::PARAM_STR);
        }

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idBrandNode
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandChildrenMappingsByBrandNodeId($idBrandNode)
    {
        return $this
            ->getFactory()
            ->createProductBrandQuery()
            ->useSpyBrandQuery()
            ->useNodeQuery()
            ->useDescendantQuery()
            ->filterByFkBrandNode($idBrandNode)
            ->endUse()
            ->endUse()
            ->endUse();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     * @param array $idsBrandNode
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandMappingsByIdAbstractProductAndIdsBrandNode(
        $idProductAbstract,
        array $idsBrandNode
    ) {
        return $this
            ->queryProductBrandMappings()
            ->filterByFkProductAbstract($idProductAbstract)
            ->useSpyBrandQuery()
            ->useNodeQuery()
            ->withColumn(
                SpyBrandNodeTableMap::COL_ID_BRAND_NODE,
                static::VIRTUAL_COLUMN_ID_BRAND_NODE
            )
            ->filterByIdBrandNode($idsBrandNode, Criteria::IN)
            ->endUse()
            ->endUse();
    }
}

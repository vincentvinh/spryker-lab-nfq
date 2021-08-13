<?php

namespace Pyz\Zed\ProductBrand\Persistence;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Brand\Persistence\SpyProductBrandQuery;
use Orm\Zed\Locale\Persistence\Map\SpyLocaleTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractLocalizedAttributesTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandPersistenceFactory getFactory()
 */
class ProductBrandQueryContainer extends AbstractQueryContainer implements ProductBrandQueryContainerInterface
{
    public const COL_CATEGORY_NAME = 'brand_name';
    public const VIRTUAL_COLUMN_ID_CATEGORY_NODE = 'id_brand_node';

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
     * @api
     *
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductsByBrandId($idBrand, LocaleTransfer $locale)
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
                SpyProductBrandTableMap::COL_PRODUCT_ORDER,
                'product_order'
            )
            ->withColumn(
                SpyProductBrandTableMap::COL_ID_PRODUCT_CATEGORY,
                'id_product_brand'
            )
            ->filterByFkBrand($idBrand)
            ->orderByFkProductAbstract();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string|null $term
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function queryProductsAbstractBySearchTermForAssignment($term, $idBrand, LocaleTransfer $localeTransfer)
    {
        $query = $this->queryProductsAbstractBySearchTerm($term, $localeTransfer);
        $query->addJoin(
            [SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT, $idBrand],
            [SpyProductBrandTableMap::COL_FK_PRODUCT_ABSTRACT, SpyProductBrandTableMap::COL_FK_CATEGORY],
            Criteria::LEFT_JOIN
        )
            ->addAnd(
                SpyProductBrandTableMap::COL_FK_CATEGORY,
                null,
                Criteria::ISNULL
            );

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string|null $term
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
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
                SpyBrandNodeTableMap::COL_ID_CATEGORY_NODE,
                static::VIRTUAL_COLUMN_ID_CATEGORY_NODE
            )
            ->filterByIdBrandNode($idsBrandNode, Criteria::IN)
            ->endUse()
            ->endUse();
    }
}

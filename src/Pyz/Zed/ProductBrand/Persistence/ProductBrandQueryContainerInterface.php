<?php

namespace Pyz\Zed\ProductBrand\Persistence;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Brand\Persistence\SpyProductBrandQuery;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface ProductBrandQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @api
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandMappings();

    /**
     * @api
     *
     * @param int $idBrand
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandMappingsByBrandId($idBrand);

    /**
     * @api
     *
     * @param int $idBrand
     * @param int $idProductAbstract
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandMappingByIds($idBrand, $idProductAbstract);

    /**
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return SpyProductBrandQuery
     */
    public function queryLocalizedProductBrandMappingByIdProduct($idProductAbstract);

    /**
     * @api
     *
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductsByBrandId($idBrand, LocaleTransfer $locale);

    /**
     * @api
     *
     * @param string|null $term
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return SpyProductAbstractQuery
     */
    public function queryProductsAbstractBySearchTermForAssignment($term, $idBrand, LocaleTransfer $locale);

    /**
     * @api
     *
     * @param string|null $term
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function queryProductsAbstractBySearchTerm($term, LocaleTransfer $locale);

    /**
     * @api
     *
     * @param int $idBrandNode
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandChildrenMappingsByBrandNodeId($idBrandNode);

    /**
     * @api
     *
     * @param int $idProductAbstract
     * @param int[] $idsBrandNode
     *
     * @return SpyProductBrandQuery
     */
    public function queryProductBrandMappingsByIdAbstractProductAndIdsBrandNode($idProductAbstract, array $idsBrandNode);
}

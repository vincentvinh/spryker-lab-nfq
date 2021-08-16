<?php

namespace Pyz\Zed\ProductBrand\Persistence;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface ProductBrandQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @api
     *
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
     */
    public function queryProductBrandMappings();

    /**
     * @api
     *
     * @param int $idBrand
     *
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
     */
    public function queryProductBrandMappingsByBrandId($idBrand);

    /**
     * @api
     *
     * @param int $idBrand
     * @param int $idProductAbstract
     *
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
     */
    public function queryProductBrandMappingByIds($idBrand, $idProductAbstract);

    /**
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
     */
    public function queryLocalizedProductBrandMappingByIdProduct($idProductAbstract);

    /**
     * @api
     *
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
     */
    public function queryProductsByBrandId(int $idBrand, LocaleTransfer $locale);

    /**
     * @api
     *
     * @param string|null $term
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
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
     * @param int $idProductAbstract
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
     * @api
     *
     */
    public function queryProductBrandMappingsByIdAbstractProductAndIdsBrandNode($idProductAbstract);
}

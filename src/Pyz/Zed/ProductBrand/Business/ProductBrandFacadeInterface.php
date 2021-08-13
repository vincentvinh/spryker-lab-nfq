<?php

namespace Pyz\Zed\ProductBrand\Business;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Propel\Runtime\Exception\PropelException;

interface ProductBrandFacadeInterface
{
    /**
     * Specification:
     * - Creates and persists new brand mapping entries to database.
     * - If a product brand mapping already exists, same logic will still apply.
     * - Touches affected brand.
     * - Touches affected abstract products.
     *
     * @api
     *
     * @param int $idBrand
     * @param array $productIdsToAssign
     *
     * @throws PropelException
     *
     * @return void
     */
    public function createProductBrandMappings($idBrand, array $productIdsToAssign);

    /**
     * Specification:
     * - Removes existing product brand mapping entries from database.
     * - Touches affected brand.
     * - Touches affected abstract products.
     *
     * @api
     *
     * @param int $idBrand
     * @param array $productIdsToUnAssign
     *
     * @return void
     */
    public function removeProductBrandMappings($idBrand, array $productIdsToUnAssign);

    /**
     * Specification:
     * - Updates order of existing product brand mapping entries in database.
     * - Touches affected brand.
     * - Touches affected abstract products.
     *
     * @api
     *
     * @param int $idBrand
     * @param array $productOrderList
     *
     * @throws PropelException
     *
     * @return void
     */
    public function updateProductMappingsOrder($idBrand, array $productOrderList);

    /**
     * Specification:
     * - Removes all existing product brand mapping entries from database.
     * - Touches affected brand.
     * - Touches affected abstract products.
     *
     * @api
     *
     * @param int $idBrand
     *
     * @return void
     */
    public function removeAllProductMappingsForBrand($idBrand);

    /**
     * Specification:
     * - Returns all abstract products that are assigned to the given brand.
     * - The data of the returned products are localized based on the given locale transfer.
     *
     * @param int $idBrand
     * @param LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer[]
     *@api
     *
     */
    public function getAbstractProductsByIdBrand($idBrand, LocaleTransfer $localeTransfer);

    /**
     * Specification:
     * - Touches related abstract-products for the given brand and all of its children
     *
     * @api
     *
     * @param BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function updateAllProductMappingsForUpdatedBrand(BrandTransfer $brandTransfer);

    /**
     * Specification:
     * - Returns all brands that are assigned to the given abstract product.
     * - The data of the returned brands are localized based on the given locale transfer.
     *
     * @param int $idProductAbstract
     * @param LocaleTransfer $localeTransfer
     *
     * @return BrandCollectionTransfer
     *@api
     *
     */
    public function getBrandTransferCollectionByIdProductAbstract(int $idProductAbstract, LocaleTransfer $localeTransfer): BrandCollectionTransfer;

    /**
     * Specification:
     *  - Returns all concrete product ids by provided brand ids.
     *
     * @api
     *
     * @param int[] $brandIds
     *
     * @return int[]
     */
    public function getProductConcreteIdsByBrandIds(array $brandIds): array;

}

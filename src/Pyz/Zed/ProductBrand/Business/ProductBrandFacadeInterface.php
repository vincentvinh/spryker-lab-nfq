<?php

namespace Pyz\Zed\ProductBrand\Business;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

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
     * @throws \Propel\Runtime\Exception\PropelException
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
     * @api
     *
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer[]
     */
    public function getAbstractProductsByIdBrand($idBrand, LocaleTransfer $localeTransfer);

    /**
     * Specification:
     * - Returns all brands that are assigned to the given abstract product.
     * - The data of the returned brands are localized based on the given locale transfer.
     *
     * @api
     *
     * @param int $idProductAbstract
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
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

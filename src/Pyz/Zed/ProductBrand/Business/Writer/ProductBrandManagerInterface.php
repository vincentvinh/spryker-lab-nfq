<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Business\Writer;

use Generated\Shared\Transfer\LocaleTransfer;

interface ProductBrandManagerInterface
{
    /**
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer[]
     */
    public function getAbstractProductTransferCollectionByBrand($idBrand, LocaleTransfer $localeTransfer);

    /**
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrand[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getProductsByBrand($idBrand, LocaleTransfer $locale);

    /**
     * @param int $idBrand
     * @param int $idProductAbstract
     *
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
     */
    public function getProductBrandMappingById($idBrand, $idProductAbstract);

    /**
     * @param int $idBrand
     * @param array $productIdsToAssign
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return void
     */
    public function createProductBrandMappings($idBrand, array $productIdsToAssign);

    /**
     * @param int $idBrand
     *
     * @return void
     */
    public function removeMappings($idBrand);

    /**
     * @param int $idBrand
     * @param array $productIdsToUnAssign
     *
     * @return void
     */
    public function removeProductBrandMappings($idBrand, array $productIdsToUnAssign);
}

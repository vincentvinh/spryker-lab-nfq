<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Business\Writer;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Orm\Zed\Brand\Persistence\SpyProductBrand;
use Orm\Zed\Brand\Persistence\SpyProductBrandQuery;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Exception\PropelException;

interface ProductBrandManagerInterface
{
    /**
     * @param int $idBrand
     * @param LocaleTransfer $localeTransfer
     *
     * @return ProductAbstractTransfer[]
     */
    public function getAbstractProductTransferCollectionByBrand($idBrand, LocaleTransfer $localeTransfer);

    /**
     * @param int $idBrand
     * @param LocaleTransfer $locale
     *
     * @return SpyProductBrand[]|ObjectCollection
     */
    public function getProductsByBrand($idBrand, LocaleTransfer $locale);

    /**
     * @param int $idBrand
     * @param int $idProductAbstract
     *
     * @return SpyProductBrandQuery
     */
    public function getProductBrandMappingById($idBrand, $idProductAbstract);

    /**
     * @param int $idBrand
     * @param array $productIdsToAssign
     *
     * @throws PropelException
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

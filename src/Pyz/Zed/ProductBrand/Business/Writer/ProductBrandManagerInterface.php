<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Business\Writer;

use Generated\Shared\Transfer\CategoryTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Orm\Zed\ProductCategory\Persistence\SpyProductCategory;
use Orm\Zed\ProductCategory\Persistence\SpyProductCategoryQuery;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Exception\PropelException;

interface ProductBrandManagerInterface
{
    /**
     * @param int $idCategory
     * @param LocaleTransfer $localeTransfer
     *
     * @return ProductAbstractTransfer[]
     */
    public function getAbstractProductTransferCollectionByCategory($idCategory, LocaleTransfer $localeTransfer);

    /**
     * @param int $idCategory
     * @param LocaleTransfer $locale
     *
     * @return SpyProductCategory[]|ObjectCollection
     */
    public function getProductsByCategory($idCategory, LocaleTransfer $locale);

    /**
     * @param int $idCategory
     * @param int $idProductAbstract
     *
     * @return SpyProductCategoryQuery
     */
    public function getProductCategoryMappingById($idCategory, $idProductAbstract);

    /**
     * @param int $idCategory
     * @param array $productIdsToAssign
     *
     * @throws PropelException
     *
     * @return void
     */
    public function createProductCategoryMappings($idCategory, array $productIdsToAssign);

    /**
     * @param int $idCategory
     *
     * @return void
     */
    public function removeMappings($idCategory);

    /**
     * @param int $idCategory
     * @param array $productIdsToUnAssign
     *
     * @return void
     */
    public function removeProductCategoryMappings($idCategory, array $productIdsToUnAssign);

    /**
     * @param int $idCategory
     * @param array $productOrderList
     *
     * @throws PropelException
     *
     * @return void
     */
    public function updateProductMappingsOrder($idCategory, array $productOrderList);

    /**
     * @param CategoryTransfer $categoryTransfer
     *
     * @return void
     */
    public function updateProductMappingsForUpdatedCategory(CategoryTransfer $categoryTransfer);
}

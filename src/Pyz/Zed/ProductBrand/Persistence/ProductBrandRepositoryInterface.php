<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Persistence;

use Generated\Shared\Transfer\BrandCollectionTransfer;

interface ProductBrandRepositoryInterface
{
    /**
     * @param int $idProductAbstract
     * @param int $idLocale
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getBrandTransferCollectionByIdProductAbstract(int $idProductAbstract, int $idLocale): BrandCollectionTransfer;

    /**
     * @param int[] $brandIds
     *
     * @return int[]
     */
    public function getProductConcreteIdsByBrandIds(array $brandIds): array;
}

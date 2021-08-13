<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Persistence;

use Generated\Shared\Transfer\BrandCollectionTransfer;

interface ProductBrandRepositoryInterface
{
    /**
     * @param int $idProductAbstract
     * @param int $idLocale
     *
     * @return BrandCollectionTransfer
     */
    public function getBrandTransferCollectionByIdProductAbstract(int $idProductAbstract, int $idLocale): BrandCollectionTransfer;

    /**
     * @param int[] $brandIds
     *
     * @return int[]
     */
    public function getProductConcreteIdsByBrandIds(array $brandIds): array;
}

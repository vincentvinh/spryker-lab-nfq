<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Persistence;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

interface BrandRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getAllBrandCollection(LocaleTransfer $localeTransfer): BrandCollectionTransfer;

    /**
     * @param int $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    public function findBrandById(int $idBrand): ?BrandTransfer;
}

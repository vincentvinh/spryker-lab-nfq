<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Business\Reader;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

interface BrandReaderInterface
{
    /**
     * @param int $idProductAbstract
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getBrandTransferCollectionByIdProductAbstract(int $idProductAbstract, LocaleTransfer $localeTransfer): BrandCollectionTransfer;
}

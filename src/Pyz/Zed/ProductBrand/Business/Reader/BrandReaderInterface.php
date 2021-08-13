<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Business\Reader;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

interface BrandReaderInterface
{
    /**
     * @param int $idProductAbstract
     * @param LocaleTransfer $localeTransfer
     *
     * @return BrandCollectionTransfer
     */
    public function getBrandTransferCollectionByIdProductAbstract(int $idProductAbstract, LocaleTransfer $localeTransfer): BrandCollectionTransfer;
}

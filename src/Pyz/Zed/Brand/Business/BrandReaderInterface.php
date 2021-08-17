<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

/**
 * Interface BrandReaderInterface
 *
 * @package Pyz\Zed\Brand\Business
 */
interface BrandReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getAllBrands(LocaleTransfer $localeTransfer): BrandCollectionTransfer;
}

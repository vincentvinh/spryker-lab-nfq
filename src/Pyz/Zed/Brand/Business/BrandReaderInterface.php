<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandTransfer;

/**
 * Interface BrandReaderInterface
 *
 * @package Pyz\Zed\Brand\Business
 */
interface BrandReaderInterface
{
    /**
     * @param int $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    public function getBrand(int $idBrand): ?BrandTransfer;
}

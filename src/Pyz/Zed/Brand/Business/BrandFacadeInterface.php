<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandCollectionTransfer;

interface BrandFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getAllBrands(): BrandCollectionTransfer;

    /**
     * @return mixed
     */
    public function getCurrentLocale();

    /**
     * @param $brandId
     *
     * @return mixed
     */
    public function getBrandById($brandId);
}

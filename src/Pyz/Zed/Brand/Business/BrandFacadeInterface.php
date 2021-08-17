<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\LocaleTransfer;

interface BrandFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getCurrentLocale(): LocaleTransfer;

    /**
     * @param int $brandId
     *
     * @return mixed
     */
    public function getBrandById(int $brandId);
}

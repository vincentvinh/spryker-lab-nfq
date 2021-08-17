<?php

namespace Pyz\Zed\Brand\Business\Model\BrandUrl;

use Generated\Shared\Transfer\BrandTransfer;

interface BrandUrlInterface
{
    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     */
    public function create(BrandTransfer $brandTransfer);

    /**
     * @return mixed
     */
    public function update(BrandTransfer $brandTransfer);

    /**
     * Delete Brand Url
     *
     * @api
     *
     * @return mixed
     */
    public function delete(BrandTransfer $brandTransfer);
}

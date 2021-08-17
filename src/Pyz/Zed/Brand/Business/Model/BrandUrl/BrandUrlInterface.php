<?php

namespace Pyz\Zed\Brand\Business\Model\BrandUrl;

use Generated\Shared\Transfer\BrandTransfer;

interface BrandUrlInterface
{
    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return mixed
     */
    public function create(BrandTransfer $brandTransfer);

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return mixed
     */
    public function update(BrandTransfer $brandTransfer);

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return mixed
     */
    public function delete(BrandTransfer $brandTransfer);
}

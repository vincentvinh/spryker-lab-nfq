<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandTransfer;

/**
 * Interface BrandReaderInterface
 *
 * @package Pyz\Zed\Brand\Business
 */
interface BrandWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return mixed
     */
    public function delete(BrandTransfer $brandTransfer);

    public function create(BrandTransfer $brandTransfer);

    public function update(BrandTransfer $brandTransfer);
}

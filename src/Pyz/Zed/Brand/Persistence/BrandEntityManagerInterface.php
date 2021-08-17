<?php

namespace Pyz\Zed\Brand\Persistence;

use Generated\Shared\Transfer\BrandTransfer;

/**
 * Interface BrandEntityManagerInterface
 *
 * @package Pyz\Zed\Brand\Persistence
 */
interface BrandEntityManagerInterface
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

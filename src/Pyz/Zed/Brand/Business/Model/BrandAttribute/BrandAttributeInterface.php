<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Business\Model\BrandAttribute;

use Generated\Shared\Transfer\BrandTransfer;

interface BrandAttributeInterface
{
    public function read($idBrand, BrandTransfer $brandTransfer);

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function create(BrandTransfer $brandTransfer);

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function update(BrandTransfer $brandTransfer);

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function delete(BrandTransfer $brandTransfer);
}

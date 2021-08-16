<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Persistence\Mapper;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Propel\Runtime\Collection\ObjectCollection;

interface BrandMapperInterface
{
    /**
     * @param \Orm\Zed\Brand\Persistence\SpyProductBrand[]|\Propel\Runtime\Collection\ObjectCollection $brandEntities
     * @param \Generated\Shared\Transfer\BrandCollectionTransfer $brandCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function mapBrandCollection(
        ObjectCollection $brandEntities,
        BrandCollectionTransfer $brandCollectionTransfer
    ): BrandCollectionTransfer;
}

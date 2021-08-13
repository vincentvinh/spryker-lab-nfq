<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Persistence\Mapper;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Orm\Zed\Brand\Persistence\SpyProductBrand;
use Propel\Runtime\Collection\ObjectCollection;

interface BrandMapperInterface
{
    /**
     * @param SpyProductBrand[]|ObjectCollection $brandEntities
     * @param BrandCollectionTransfer $brandCollectionTransfer
     *
     * @return BrandCollectionTransfer
     */
    public function mapBrandCollection(
        ObjectCollection $brandEntities,
        BrandCollectionTransfer $brandCollectionTransfer
    ): BrandCollectionTransfer;
}

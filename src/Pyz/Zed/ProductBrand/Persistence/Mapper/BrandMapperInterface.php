<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Persistence\Mapper;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Propel\Runtime\Collection\ObjectCollection;

interface BrandMapperInterface
{
    /**
     * @param \Orm\Zed\ProductBrand\Persistence\SpyProductBrand[]|\Propel\Runtime\Collection\ObjectCollection $brandEntities
     * @param \Generated\Shared\Transfer\BrandCollectionTransfer $brandCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function mapBrandCollection(
        ObjectCollection $brandEntities,
        BrandCollectionTransfer $brandCollectionTransfer
    ): BrandCollectionTransfer;
}

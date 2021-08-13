<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Persistence\Mapper;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Brand\Persistence\SpyBrand;
use Orm\Zed\Brand\Persistence\SpyProductBrand;
use Propel\Runtime\Collection\ObjectCollection;

class BrandMapper implements BrandMapperInterface
{
    /**
     * @param SpyBrand $spyBrand
     * @param BrandTransfer $brandTransfer
     *
     * @return BrandTransfer
     */
    protected function mapBrand(SpyBrand $spyBrand, BrandTransfer $brandTransfer): BrandTransfer
    {
        return $brandTransfer->fromArray($spyBrand->toArray(), true);
    }

    /**
     * @param SpyBrand $brandEntity
     * @param BrandTransfer $brandTransfer
     *
     * @return void
     */
    protected function mapLocalizedAttributes(SpyBrand $brandEntity, BrandTransfer $brandTransfer): void
    {
        foreach ($brandEntity->getAttributes() as $attribute) {
            $localeTransfer = new LocaleTransfer();
            $localeTransfer->fromArray($attribute->getLocale()->toArray(), true);

            $brandLocalizedAttributesTransfer = new BrandLocalizedAttributeTransfer();
            $brandLocalizedAttributesTransfer->fromArray($attribute->toArray(), true);
            $brandLocalizedAttributesTransfer->setLocale($localeTransfer);

            $brandTransfer->addLocalizedAttributes($brandLocalizedAttributesTransfer);
        }
    }

    /**
     * @param SpyProductBrand[]|ObjectCollection $productBrandEntities
     * @param BrandCollectionTransfer $brandCollectionTransfer
     *
     * @return BrandCollectionTransfer
     */
    public function mapBrandCollection(
        ObjectCollection $productBrandEntities,
        BrandCollectionTransfer $brandCollectionTransfer
    ): BrandCollectionTransfer {
        foreach ($productBrandEntities as $productBrandEntity) {
            /** @var SpyBrand|null $brandEntity */
            $brandEntity = $productBrandEntity->getSpyBrand();
            if ($brandEntity === null) {
                continue;
            }
            $brandTransfer = $this->mapBrand($brandEntity, new BrandTransfer());
            $this->mapLocalizedAttributes($brandEntity, $brandTransfer);

            foreach ($brandTransfer->getLocalizedAttributes() as $localizedAttribute) {
                $brandTransfer->fromArray($localizedAttribute->toArray(), true);
            }

            $brandCollectionTransfer->addBrand($brandTransfer);
        }

        return $brandCollectionTransfer;
    }
}

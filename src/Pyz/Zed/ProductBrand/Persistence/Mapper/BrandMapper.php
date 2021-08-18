<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Persistence\Mapper;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Brand\Persistence\SpyBrand;
use Propel\Runtime\Collection\ObjectCollection;

class BrandMapper implements BrandMapperInterface
{
    /**
     * @param \Orm\Zed\Brand\Persistence\SpyBrand $spyBrand
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandTransfer
     */
    protected function mapBrand(SpyBrand $spyBrand, BrandTransfer $brandTransfer): BrandTransfer
    {
        return $brandTransfer->fromArray($spyBrand->toArray(), true);
    }

    /**
     * @param \Orm\Zed\Brand\Persistence\SpyBrand $brandEntity
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    protected function mapLocalizedAttributes(SpyBrand $brandEntity, BrandTransfer $brandTransfer): void
    {
        foreach ($brandEntity->getAttributes() as $attribute) {
            $localeTransfer = new LocaleTransfer();
            $localeTransfer->fromArray($attribute->getLocale()->toArray(), true);

            $brandLocalizedAttributeTransfer = new BrandLocalizedAttributeTransfer();
            $brandLocalizedAttributeTransfer->fromArray($attribute->toArray(), true);
            $brandLocalizedAttributeTransfer->setLocale($localeTransfer);

            $brandTransfer->addLocalizedAttributes($brandLocalizedAttributeTransfer);
        }
    }

    /**
     * @param \Orm\Zed\Brand\Persistence\SpyProductBrand[]|\Propel\Runtime\Collection\ObjectCollection $productBrandEntities
     * @param \Generated\Shared\Transfer\BrandCollectionTransfer $brandCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function mapBrandCollection(
        ObjectCollection $productBrandEntities,
        BrandCollectionTransfer $brandCollectionTransfer
    ): BrandCollectionTransfer {
        foreach ($productBrandEntities as $productBrandEntity) {
            /** @var \Orm\Zed\Brand\Persistence\SpyBrand|null $brandEntity */
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

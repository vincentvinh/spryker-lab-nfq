<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Persistence;

use Generated\Shared\Transfer\BrandLocalizedAttributesTransfer;
use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\Brand\Persistence\BrandPersistenceFactory getFactory()
 */
class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
    public const IS_NOT_ROOT_NODE = 0;
    protected const COL_CATEGORY_NAME = 'name';

    /**
     * @param int $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    public function findBrandById(int $idBrand): ?BrandTransfer
    {
        $spyBrandEntity = $this->getFactory()
            ->createBrandQuery()
            ->findByIdBrand($idBrand)
            ->getFirst();

        if ($spyBrandEntity === null) {
            return null;
        }

        $brandTransfer = new BrandTransfer();
        $brandTransfer->fromArray($spyBrandEntity->toArray());
        foreach ($spyBrandEntity->getAttributes() as $attribute) {
            $localeTransfer = new LocaleTransfer();
            $localeTransfer->fromArray($attribute->getLocale()->toArray(), true);

            $brandLocalizedAttributeTransfer = new BrandLocalizedAttributeTransfer();
            $brandLocalizedAttributeTransfer->fromArray($attribute->toArray(), true);
            $brandLocalizedAttributeTransfer->setLocale($localeTransfer);

            $brandTransfer->addLocalizedAttributes($brandLocalizedAttributeTransfer);
        }

        return $brandTransfer;
    }
}

<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Persistence;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandLocalizedAttributesTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Brand\Persistence\Map\SpyBrandAttributeTableMap;
use Orm\Zed\Brand\Persistence\SpyBrandQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

/**
 * @method \Pyz\Zed\Brand\Persistence\BrandPersistenceFactory getFactory()
 */
class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
    public const IS_NOT_ROOT_NODE = 0;
    protected const COL_CATEGORY_NAME = 'name';

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getAllBrandCollection(LocaleTransfer $localeTransfer): BrandCollectionTransfer
    {
        $brandQuery = SpyBrandQuery::create();
        $spyBrands = $brandQuery
            ->joinWithAttribute()
            ->addAnd(
                SpyBrandAttributeTableMap::COL_FK_LOCALE,
                $localeTransfer->getIdLocale(),
                Criteria::EQUAL
            )
            ->find();

        return $this->getFactory()
            ->createBrandMapper()
            ->mapBrandCollection($spyBrands, new BrandCollectionTransfer());
    }

    /**
     * @param int $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    public function findBrandById(int $idBrand): ?BrandTransfer
    {
        /**
         * @var $spyBrandEntity SpyBrand
         */
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

            $brandLocalizedAttributesTransfer = new BrandLocalizedAttributesTransfer();
            $brandLocalizedAttributesTransfer->fromArray($attribute->toArray(), true);
            $brandLocalizedAttributesTransfer->setLocale($localeTransfer);

            $brandTransfer->addLocalizedAttributes($brandLocalizedAttributesTransfer);
        }

        return $brandTransfer;
    }
}

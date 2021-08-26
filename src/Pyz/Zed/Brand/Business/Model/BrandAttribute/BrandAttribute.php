<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Business\Model\BrandAttribute;

use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Orm\Zed\Brand\Persistence\SpyBrandAttribute;
use Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface;

class BrandAttribute implements BrandAttributeInterface
{
    /**
     * @var \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface $queryContainer
     */
    protected $queryContainer;

    /**
     * @param \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface $queryContainer
     */
    public function __construct(BrandQueryContainerInterface $queryContainer)
    {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function create(BrandTransfer $brandTransfer)
    {
        $localizedAttributesTransferCollection = $brandTransfer->getLocalizedAttributes();

        foreach ($localizedAttributesTransferCollection as $localizedAttributesTransfer) {
            $localizedBrandAttributeEntity = new SpyBrandAttribute();

            $localizedBrandAttributeEntity = $this->updateEntity(
                $localizedBrandAttributeEntity,
                $localizedAttributesTransfer,
                $brandTransfer->getIdBrand()
            );

            $localizedBrandAttributeEntity->save();
        }
    }

    /**
     * @param \Orm\Zed\Brand\Persistence\SpyBrandAttribute $spyBrandAttribute
     * @param \Generated\Shared\Transfer\BrandLocalizedAttributeTransfer $brandLocalizedAttributeTransfer
     * @param int $idBrand
     *
     * @return \Orm\Zed\Brand\Persistence\SpyBrandAttribute
     */
    protected function updateEntity(
        SpyBrandAttribute $spyBrandAttribute,
        BrandLocalizedAttributeTransfer $brandLocalizedAttributeTransfer,
        int $idBrand
    ) {
        $spyBrandAttribute->fromArray($brandLocalizedAttributeTransfer->toArray());
        $spyBrandAttribute->setFkBrand($idBrand);
        $localeTransfer = $brandLocalizedAttributeTransfer->requireLocale()->getLocale();
        $idLocale = $localeTransfer->requireIdLocale()->getIdLocale();
        $spyBrandAttribute->setFkLocale($idLocale);

        return $spyBrandAttribute;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function update(BrandTransfer $brandTransfer)
    {
        $idBrand = $brandTransfer->requireIdBrand()->getIdBrand();
        $localizedAttributesTransferCollection = $brandTransfer->getLocalizedAttributes();

        foreach ($localizedAttributesTransferCollection as $localizedAttributesTransfer) {
            $localeTransfer = $localizedAttributesTransfer->requireLocale()->getLocale();
            $idLocale = $localeTransfer->requireIdLocale()->getIdLocale();

            $localizedBrandAttributesEntity = $this
                ->queryContainer
                ->queryAttributeByBrandId($idBrand)
                ->filterByFkLocale($idLocale)
                ->findOneOrCreate();

            $localizedBrandAttributesEntity = $this->updateEntity(
                $localizedBrandAttributesEntity,
                $localizedAttributesTransfer,
                $idBrand
            );

            $localizedBrandAttributesEntity->save();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function delete(BrandTransfer $brandTransfer)
    {
        $this->queryContainer->queryAttributeByBrandId($brandTransfer->getIdBrand())->delete();
    }
}

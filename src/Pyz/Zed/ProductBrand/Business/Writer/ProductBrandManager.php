<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Business\Writer;

use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\LocalizedAttributesTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductBrandTransfer;
use Orm\Zed\Brand\Persistence\SpyProductBrand;
use Orm\Zed\Brand\Persistence\SpyProductBrandQuery;
use Propel\Runtime\Collection\ObjectCollection;
use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ProductBrandManager implements ProductBrandManagerInterface
{
    /**
     * @var ProductBrandQueryContainerInterface
     */
    protected $productBrandQueryContainer;

    /**
     * @var BrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @var ProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @var EventFacadeInterface
     */
    protected $eventFacade;

    /**
     * @param ProductBrandQueryContainerInterface $productBrandQueryContainer
     * @param BrandFacadeInterface $brandFacade
     * @param ProductFacadeInterface $productFacade
     * @param EventFacadeInterface|null $eventFacade
     */
    public function __construct(
        ProductBrandQueryContainerInterface $productBrandQueryContainer,
        BrandFacadeInterface $brandFacade,
        ProductFacadeInterface $productFacade,
        ?EventFacadeInterface $eventFacade = null
    ) {
        $this->productBrandQueryContainer = $productBrandQueryContainer;
        $this->brandFacade = $brandFacade;
        $this->productFacade = $productFacade;
        $this->eventFacade = $eventFacade;
    }

    /**
     * @param int $idBrand
     * @param LocaleTransfer $localeTransfer
     *
     * @return ProductAbstractTransfer[]
     */
    public function getAbstractProductTransferCollectionByBrand(
        $idBrand,
        LocaleTransfer $localeTransfer
    ) {
        $productCollection = $this->getProductsByBrand($idBrand, $localeTransfer);
        $productTransferCollection = [];

        foreach ($productCollection as $productEntity) {
            $abstractProductTransfer = (new ProductAbstractTransfer())->fromArray($productEntity->toArray(), true);

            $localizedAttributesData = json_decode($productEntity->getVirtualColumn('abstract_localized_attributes'), true);
            $localizedAttributesTransfer = new LocalizedAttributesTransfer();
            $localizedAttributesTransfer->setName($productEntity->getVirtualColumn('name'));
            $localizedAttributesTransfer->setLocale($localeTransfer);
            $localizedAttributesTransfer->setAttributes($localizedAttributesData);
            $abstractProductTransfer->addLocalizedAttributes($localizedAttributesTransfer);

            $productTransferCollection[] = $abstractProductTransfer;
        }

        return $productTransferCollection;
    }

    /**
     * @param int $idBrand
     * @param LocaleTransfer $locale
     *
     * @return SpyProductBrand[]|ObjectCollection
     */
    public function getProductsByBrand($idBrand, LocaleTransfer $locale)
    {
        return $this->productBrandQueryContainer
            ->queryProductsByBrandId($idBrand, $locale)
            ->orderByFkProductAbstract()
            ->find();
    }

    /**
     * @param int $idBrand
     * @param int $idProductAbstract
     *
     * @return SpyProductBrandQuery
     */
    public function getProductBrandMappingById($idBrand, $idProductAbstract)
    {
        return $this->productBrandQueryContainer
            ->queryProductBrandMappingByIds($idBrand, $idProductAbstract);
    }

    /**
     * @param int $idBrand
     * @param array $productIdsToUnAssign
     *
     * @return void
     */
    public function removeProductBrandMappings($idBrand, array $productIdsToUnAssign)
    {
        foreach ($productIdsToUnAssign as $idProductAbstract) {
            $mapping = $this->getProductBrandMappingById($idBrand, $idProductAbstract)
                ->findOne();

            if ($mapping === null) {
                continue;
            }

            $mapping->delete();
        }
    }

    /**
     * @param int $idBrand
     * @param array $productIdsToAssign
     *
     * @return void
     */
    public function createProductBrandMappings($idBrand, array $productIdsToAssign)
    {
        foreach ($productIdsToAssign as $idProductAbstract) {
            $mapping = $this->getProductBrandMappingById($idBrand, $idProductAbstract)
                ->findOneOrCreate();

            $mapping->setFkBrand($idBrand);
            $mapping->setFkProductAbstract($idProductAbstract);
            $mapping->save();
        }
    }

    /**
     * @param int $idBrand
     *
     * @return void
     */
    public function removeMappings($idBrand)
    {
        $assignedProducts = $this->productBrandQueryContainer
            ->queryProductBrandMappingsByBrandId($idBrand)
            ->find();

        $productIdsToUnAssign = [];
        foreach ($assignedProducts as $mapping) {
            $productIdsToUnAssign[] = $mapping->getFkProductAbstract();
        }
        $this->removeProductBrandMappings($idBrand, $productIdsToUnAssign);
    }

    /**
     * @param int $idBrand
     * @param int $idProductAbstract
     *
     * @return ProductBrandTransfer
     */
    protected function createProductBrandTransfer(int $idBrand,int $idProductAbstract)
    {
        $productBrandTransfer = new ProductBrandTransfer();
        $productBrandTransfer->setFkBrand($idBrand);
        $productBrandTransfer->setFkProductAbstract($idProductAbstract);

        return $productBrandTransfer;
    }
}

<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Business\Writer;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\LocalizedAttributesTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductBrandTransfer;
use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ProductBrandManager implements ProductBrandManagerInterface
{
    /**
     * @var \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface
     */
    protected $productBrandQueryContainer;

    /**
     * @var \Pyz\Zed\Brand\Business\BrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @var \Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @var \Spryker\Zed\Event\Business\EventFacadeInterface
     */
    protected $eventFacade;

    /**
     * @param \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface $productBrandQueryContainer
     * @param \Pyz\Zed\Brand\Business\BrandFacadeInterface $brandFacade
     * @param \Spryker\Zed\Product\Business\ProductFacadeInterface $productFacade
     * @param \Spryker\Zed\Event\Business\EventFacadeInterface|null $eventFacade
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
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer[]
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
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     *
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrand[]|\Propel\Runtime\Collection\ObjectCollection
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
     * @return \Orm\Zed\Brand\Persistence\SpyProductBrandQuery
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
     * @return \Generated\Shared\Transfer\ProductBrandTransfer
     */
    protected function createProductBrandTransfer(int $idBrand, int $idProductAbstract)
    {
        $productBrandTransfer = new ProductBrandTransfer();
        $productBrandTransfer->setFkBrand($idBrand);
        $productBrandTransfer->setFkProductAbstract($idProductAbstract);

        return $productBrandTransfer;
    }
}

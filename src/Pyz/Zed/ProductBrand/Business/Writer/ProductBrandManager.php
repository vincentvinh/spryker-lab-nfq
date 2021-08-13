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
use Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToBrandInterface;
use Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToEventInterface;
use Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToProductInterface;
use Spryker\Zed\ProductBrand\Dependency\ProductBrandEvents;
use Spryker\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface;

class ProductBrandManager implements ProductBrandManagerInterface
{
    /**
     * @var \Spryker\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface
     */
    protected $productBrandQueryContainer;

    /**
     * @var \Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToBrandInterface
     */
    protected $brandFacade;

    /**
     * @var \Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToProductInterface
     */
    protected $productFacade;

    /**
     * @var \Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToEventInterface
     */
    protected $eventFacade;

    /**
     * @param \Spryker\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface $productBrandQueryContainer
     * @param \Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToBrandInterface $brandFacade
     * @param \Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToProductInterface $productFacade
     * @param \Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToEventInterface|null $eventFacade
     */
    public function __construct(
        ProductBrandQueryContainerInterface $productBrandQueryContainer,
        ProductBrandToBrandInterface $brandFacade,
        ProductBrandToProductInterface $productFacade,
        ?ProductBrandToEventInterface $eventFacade = null
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
     * @return \Orm\Zed\ProductBrand\Persistence\SpyProductBrand[]|\Propel\Runtime\Collection\ObjectCollection
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
     * @return \Orm\Zed\ProductBrand\Persistence\SpyProductBrandQuery
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

            $this->triggerEvent(ProductBrandEvents::PRODUCT_CATEGORY_UNASSIGNED, $idBrand, $idProductAbstract);

            $this->touchProductAbstractActive($idProductAbstract);
        }

        $this->touchBrandActive($idBrand);
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

            $this->triggerEvent(ProductBrandEvents::PRODUCT_CATEGORY_ASSIGNED, $idBrand, $idProductAbstract);

            $this->touchProductAbstractActive($idProductAbstract);
        }

        $this->touchBrandActive($idBrand);
    }

    /**
     * @param int $idBrand
     * @param array $productOrderList
     *
     * @return void
     */
    public function updateProductMappingsOrder($idBrand, array $productOrderList)
    {
        foreach ($productOrderList as $idProduct => $order) {
            $mapping = $this->getProductBrandMappingById($idBrand, $idProduct)
                ->findOne();

            if ($mapping === null) {
                continue;
            }

            $mapping->setFkBrand($idBrand);
            $mapping->setFkProductAbstract($idProduct);
            $mapping->setProductOrder($order);
            $mapping->save();

            $this->touchProductAbstractActive($idProduct);
        }

        $this->touchBrandActive($idBrand);
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
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function touchProductAbstractActive($idProductAbstract)
    {
        $this->productFacade->touchProductAbstract($idProductAbstract);
    }

    /**
     * @param int $idBrand
     *
     * @return void
     */
    protected function touchBrandActive($idBrand)
    {
        $this->brandFacade->touchBrandActive($idBrand);
    }

    /**
     * @param int $idBrand
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductBrandTransfer
     */
    protected function createProductBrandTransfer($idBrand, $idProductAbstract)
    {
        $productBrandTransfer = new ProductBrandTransfer();
        $productBrandTransfer->setFkBrand($idBrand);
        $productBrandTransfer->setFkProductAbstract($idProductAbstract);

        return $productBrandTransfer;
    }

    /**
     * @param string $eventName
     * @param int $idBrand
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function triggerEvent($eventName, $idBrand, $idProductAbstract)
    {
        if ($this->eventFacade === null) {
            return;
        }

        $productBrandTransfer = $this->createProductBrandTransfer($idBrand, $idProductAbstract);
        $this->eventFacade->trigger($eventName, $productBrandTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function updateProductMappingsForUpdatedBrand(BrandTransfer $brandTransfer)
    {
        $idBrandNode = $brandTransfer->getBrandNode()->getIdBrandNode();
        $productMappings = $this->findProductMappingsOfChildCategories($idBrandNode);

        foreach ($productMappings as $productMappingEntity) {
            $this->touchProductAbstractActive($productMappingEntity->getFkProductAbstract());
        }
    }

    /**
     * @param int $idBrandNode
     *
     * @return \Orm\Zed\ProductBrand\Persistence\SpyProductBrand[]|\Propel\Runtime\Collection\ObjectCollection
     */
    protected function findProductMappingsOfChildCategories($idBrandNode)
    {
        return $this
            ->productBrandQueryContainer
            ->queryProductBrandChildrenMappingsByBrandNodeId($idBrandNode)
            ->find();
    }
}

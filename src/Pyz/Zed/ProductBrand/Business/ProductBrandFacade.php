<?php

namespace Pyz\Zed\ProductBrand\Business;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\ProductBrand\Business\ProductBrandBusinessFactory getFactory()
 */
class ProductBrandFacade extends AbstractFacade implements ProductBrandFacadeInterface
{

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idBrand
     * @param array $productIdsToAssign
     *
     * @return void
     */
    public function createProductBrandMappings($idBrand, array $productIdsToAssign)
    {
        $this->getFactory()
            ->createProductBrandManager()
            ->createProductBrandMappings($idBrand, $productIdsToAssign);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idBrand
     * @param array $productIdsToUnAssign
     *
     * @return void
     */
    public function removeProductBrandMappings($idBrand, array $productIdsToUnAssign)
    {
        $this->getFactory()
            ->createProductBrandManager()
            ->removeProductBrandMappings($idBrand, $productIdsToUnAssign);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idBrand
     * @param array $productOrderList
     *
     * @return void
     */
    public function updateProductMappingsOrder($idBrand, array $productOrderList)
    {
        $this->getFactory()
            ->createProductBrandManager()
            ->updateProductMappingsOrder($idBrand, $productOrderList);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idBrand
     *
     * @return void
     */
    public function removeAllProductMappingsForBrand($idBrand)
    {
        $this
            ->getFactory()
            ->createProductBrandManager()
            ->removeMappings($idBrand);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer[]
     */
    public function getAbstractProductsByIdBrand($idBrand, LocaleTransfer $localeTransfer)
    {
        return $this
            ->getFactory()
            ->createProductBrandManager()
            ->getAbstractProductTransferCollectionByBrand($idBrand, $localeTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function updateAllProductMappingsForUpdatedBrand(BrandTransfer $brandTransfer)
    {
        $this
            ->getFactory()
            ->createProductBrandManager()
            ->updateProductMappingsForUpdatedBrand($brandTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getBrandTransferCollectionByIdProductAbstract(int $idProductAbstract, LocaleTransfer $localeTransfer): BrandCollectionTransfer
    {
        return $this->getFactory()
            ->createBrandReader()
            ->getBrandTransferCollectionByIdProductAbstract($idProductAbstract, $localeTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int[] $brandIds
     *
     * @return int[]
     */
    public function getProductConcreteIdsByBrandIds(array $brandIds): array
    {
        return $this->getRepository()
            ->getProductConcreteIdsByBrandIds($brandIds);
    }

}

<?php

namespace Pyz\Zed\ProductBrand\Business;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\ProductBrand\Business\ProductBrandBusinessFactory getFactory()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface getRepository()
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
            ->createProductBrandWriter()
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
            ->createProductBrandWriter()
            ->removeProductBrandMappings($idBrand, $productIdsToUnAssign);
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
            ->createProductBrandWriter()
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
            ->createProductBrandWriter()
            ->getAbstractProductTransferCollectionByBrand($idBrand, $localeTransfer);
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

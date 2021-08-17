<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\Brand\Business\BrandBusinessFactory getFactory()
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()
 * @method \Pyz\Zed\Brand\Persistence\BrandEntityManagerInterface getEntityManager()
 */
class BrandFacade extends AbstractFacade implements BrandFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function create(BrandTransfer $brandTransfer)
    {
        $this->getFactory()->createBrand()->create($brandTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function update(BrandTransfer $brandTransfer)
    {
        $this->getFactory()->createBrand()->update($brandTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function delete(BrandTransfer $brandTransfer)
    {
        $this->getFactory()->createBrand()->delete($brandTransfer);
    }

    /**
     * @return void
     */
    public function getAllBrands(): BrandCollectionTransfer
    {
        // TODO: Implement getAllBrands() method.
    }

    /**
     * @return mixed
     */
    public function getCurrentLocale()
    {
        return $this->getFactory()->getCurrentLocale();
    }

    /**
     * |
     *
     * @param $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|mixed|null
     */
    public function getBrandById($idBrand)
    {
        return $this->getFactory()
            ->createBrandReader()
            ->getBrand($idBrand);
    }
}

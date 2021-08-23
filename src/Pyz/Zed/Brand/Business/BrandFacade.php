<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\Brand\Business\BrandBusinessFactory getFactory()
 * @method \Pyz\Zed\Brand\Persistence\BrandEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()
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
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getCurrentLocale(): LocaleTransfer
    {
        return $this->getFactory()->getCurrentLocale();
    }

    /**
     * @param int $brandId
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|mixed|null
     */
    public function getBrandById(int $brandId)
    {
        return $this->getFactory()
            ->createBrandReader()
            ->getBrand($brandId);
    }
}

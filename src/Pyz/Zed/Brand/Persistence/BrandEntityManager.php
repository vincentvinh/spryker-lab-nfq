<?php

namespace Pyz\Zed\Brand\Persistence;

use Generated\Shared\Transfer\BrandTransfer;
use Orm\Zed\Brand\Persistence\SpyBrand;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\Brand\Persistence\BrandPersistenceFactory getFactory()
 */
class BrandEntityManager extends AbstractEntityManager implements BrandEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return mixed|void
     */
    public function delete(BrandTransfer $brandTransfer)
    {
        $brandEntity = new SpyBrand();
        $brandEntity->fromArray($brandTransfer->toArray());
        $brandEntity->delete();
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function create(BrandTransfer $brandTransfer)
    {
        $brandEntity = new spyBrand();
        $brandEntity->fromArray($brandTransfer->toArray());
        $brandEntity->save();
        $brandTransfer->setIdBrand($brandEntity->getIdBrand());
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function update(BrandTransfer $brandTransfer)
    {
//        $brandEntity = $this->getBrandEntityByIdBrand($brandTransfer->getIdBrand());
//        $brandEntity->fromArray($brandTransfer->toArray());
//        $brandEntity->save();
    }
}

<?php

namespace Pyz\Zed\BrandStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\BrandStorage\Business\BrandStorageBusinessFactory getFactory()
 */
class BrandStorageFacade extends AbstractFacade implements BrandStorageWriteInterface
{
    /**
     * @param array $brandIds
     * @return mixed|void
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function publish(array $brandIds)
    {
        $this->getFactory()->getBrandStorageWrite()->publish($brandIds);
    }
}

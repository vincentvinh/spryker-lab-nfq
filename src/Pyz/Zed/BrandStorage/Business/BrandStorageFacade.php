<?php

namespace Pyz\Zed\BrandStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\BrandStorage\Business\BrandStorageBusinessFactory getFactory()
 */
class BrandStorageFacade extends AbstractFacade implements BrandStorageFacadeInterface
{
    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function publish(array $brandIds)
    {
        $this->getFactory()->createBrandStorageWrite()->publish($brandIds);
    }
}

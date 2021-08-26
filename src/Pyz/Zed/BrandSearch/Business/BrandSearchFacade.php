<?php

namespace Pyz\Zed\BrandSearch\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\BrandSearch\Business\BrandSearchBusinessFactory getFactory()
 */
class BrandSearchFacade extends AbstractFacade implements BrandSearchFacadeInterface
{

    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function publish(array $brandIds)
    {
        $this->getFactory()->createBrandSearchWriter()->publish($brandIds);
    }

    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function unPublish(array $brandIds)
    {
        $this->getFactory()->createBrandSearchWriter()->unPublish($brandIds);
    }
}

<?php

namespace Pyz\Zed\BrandStorage\Business;

interface BrandStorageFacadeInterface
{
    /**
     * @param array $brandIds
     * @return mixed
     */
    public function publish(array $brandIds);
}

<?php

namespace Pyz\Zed\BrandStorage\Business;

interface BrandStorageWriteInterface
{
    /**
     * @param array $brandIds
     * @return mixed
     */
    public function publish(array $brandIds);
}

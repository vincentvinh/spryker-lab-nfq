<?php

namespace Pyz\Zed\BrandSearch\Business;

interface BrandSearchFacadeInterface
{
    /**
     * @param array $brandIds
     *
     * @return mixed
     */
    public function publish(array $brandIds);


    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function unPublish(array $brandIds);
}

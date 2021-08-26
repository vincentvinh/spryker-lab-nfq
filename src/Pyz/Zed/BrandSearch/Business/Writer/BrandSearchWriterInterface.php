<?php

namespace Pyz\Zed\BrandSearch\Business\Writer;

interface BrandSearchWriterInterface
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
     * @return mixed
     */
    public function unPublish(array $brandIds);
}

<?php

namespace Pyz\Zed\BrandSearch\Persistence;

use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface BrandSearchQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @param array $brandIds
     *
     * @return mixed
     */
    public function getAllBrandByIds(array $brandIds);

    /**
     * @param array $brandIds
     *
     * @return mixed
     */
    public function getBrandSearchByBrandIds(array $brandIds);

    /**
     * @param int $idBrand
     *
     * @return mixed
     */
    public function queryAttributeByBrandId(int $idBrand);

    /**
     * @param array $localeNames
     *
     * @return mixed
     */
    public function queryLocalesWithLocaleNames(array $localeNames);
}
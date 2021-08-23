<?php

namespace Pyz\Zed\BrandStorage\Persistence;

use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface BrandStorageQueryContainerInterface extends QueryContainerInterface
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
    public function getBrandStorageByBrandIds(array $brandIds);

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

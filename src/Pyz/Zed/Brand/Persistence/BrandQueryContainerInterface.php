<?php

namespace Pyz\Zed\Brand\Persistence;

use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface BrandQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @param $idLocale
     *
     * @return mixed|void
     */
    public function queryListBrand($idLocale);

    /**
     * @param $nameBrand
     *
     * @return mixed
     */
    public function queryBrandByName($nameBrand);

    /**
     * @param $idBrand
     *
     * @return mixed
     */
    public function queryBrandById($idBrand);

    /**
     * @return mixed
     */
    public function queryAttributeByBrandId($idBrand);

    /**
     * @param $idBrand
     *
     * @return mixed
     */
    public function queryUrlByIdBrand($idBrand);
}

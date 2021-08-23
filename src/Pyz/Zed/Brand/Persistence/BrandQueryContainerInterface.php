<?php

namespace Pyz\Zed\Brand\Persistence;

use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface BrandQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @param int $idLocale
     *
     * @return mixed|void
     */
    public function queryListBrand(int $idLocale);

    /**
     * @param string $nameBrand
     *
     * @return mixed
     */
    public function queryBrandByName(string $nameBrand);

    /**
     * @param int $idBrand
     *
     * @return mixed
     */
    public function queryBrandById(int $idBrand);

    /**
     * @param int $idBrand
     *
     * @return mixed
     */
    public function queryAttributeByBrandId(int $idBrand);

    /**
     * @param int $idBrand
     *
     * @return mixed
     */
    public function queryUrlByIdBrand(int $idBrand);

    /***
     * @return mixed
     */
    public function queryAllBrand();
}

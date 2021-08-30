<?php

namespace Pyz\Zed\BrandSearch\Persistence;

use Orm\Zed\Brand\Persistence\SpyBrandQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchPersistenceFactory getFactory()
 */
class BrandSearchQueryContainer extends AbstractQueryContainer implements BrandSearchQueryContainerInterface
{
    /**
     * @param array $brandIds
     *
     * @return mixed|\Orm\Zed\Brand\Persistence\SpyBrand[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getAllBrandByIds(array $brandIds)
    {
        return $this->getAllBrand()->filterByIdBrand_In($brandIds)->find();
    }

    /**
     * @param array $brandIds
     *
     * @return \Orm\Zed\BrandSearch\Persistence\SpyBrandSearch[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getBrandSearchByBrandIds(array $brandIds)
    {
        return $this->getFactory()->createBrandSearchQuery()->filterByFkBrand_In($brandIds)->find();
    }

    /**
     * @return \Orm\Zed\Brand\Persistence\SpyBrandQuery
     */
    protected function getAllBrand(): SpyBrandQuery
    {
        return $this->getFactory()->getBrandQueryContainer()->queryAllBrand();
    }

    /**
     * @param int $idBrand
     *
     * @return mixed|void
     */
    public function queryAttributeByBrandId(int $idBrand)
    {
        return $this->getFactory()->getBrandQueryContainer()->queryAttributeByBrandId($idBrand);
    }

    /**
     * @param array $localeNames
     *
     * @return mixed
     */
    public function queryLocalesWithLocaleNames(array $localeNames)
    {
        return $this->getFactory()
            ->getLocaleQueryContainer()
            ->queryLocales()
            ->filterByLocaleName_In($localeNames)
            ->find();
    }


    /**
     * @param int $brandId
     * @param int $fkLocale
     */
    public function getQueryProductAbstractIdsByBrandLocale(int $brandId, int $fkLocale)
    {
        return $this->getFactory()->getBrandQueryContainer()->queryProductAbstractIdsByBrandLocale($brandId, $fkLocale);
    }
}

<?php

namespace Pyz\Zed\BrandStorage\Persistence;

use Orm\Zed\Brand\Persistence\SpyBrandQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\BrandStorage\Persistence\BrandStoragePersistenceFactory getFactory()
 */
class BrandStorageQueryContainer extends AbstractQueryContainer implements BrandStorageQueryContainerInterface
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
     * @return mixed|\Orm\Zed\BrandStorage\Persistence\SpyBrandStorageQuery
     */
    public function getBrandStorageByBrandIds(array $brandIds)
    {
        return $this->getFactory()->createBrandStorageQuery()->filterByFkBrand_In($brandIds);
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
}

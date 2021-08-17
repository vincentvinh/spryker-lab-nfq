<?php

namespace Pyz\Zed\Brand\Persistence;

use Orm\Zed\Brand\Persistence\Map\SpyBrandAttributeTableMap;
use Orm\Zed\Locale\Persistence\Map\SpyLocaleTableMap;
use Pyz\Shared\Brand\BrandConstants;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

/**
 * @method \Pyz\Zed\Brand\Persistence\BrandPersistenceFactory getFactory()
 */
class BrandQueryContainer extends AbstractQueryContainer implements BrandQueryContainerInterface
{
    public function queryListBrand($idLocale)
    {
        return $this->getFactory()->createBrandQuery()->create()
            ->joinAttribute()
            ->addAnd(
                SpyBrandAttributeTableMap::COL_FK_LOCALE,
                $idLocale,
                Criteria::EQUAL
            )->withColumn('spy_brand.id_brand', BrandConstants::ID_BRAND)
            ->withColumn('spy_brand.name', BrandConstants::NAME_BRAND)
            ->withColumn('spy_brand.description', BrandConstants::DESCRIPTION_BRAND)
            ->withColumn('spy_brand.logo', BrandConstants::LOGO_BRAND)
            ->withColumn('spy_brand.is_searchable', BrandConstants::IS_SEARCHABLE_BRAND)
            ->withColumn('spy_brand.is_highlight', BrandConstants::IS_HIGHLIGHT_BRAND);
    }

    /**
     * @param $nameBrand
     *
     * @return mixed|\Orm\Zed\Brand\Persistence\SpyBrandQuery
     */
    public function queryBrandByName($nameBrand)
    {
        return $this->getFactory()->createBrandQuery()->filterByName($nameBrand);
    }

    /**
     * @param $idBrand
     *
     * @return mixed|\Orm\Zed\Brand\Persistence\SpyBrandQuery
     */
    public function queryBrandById($idBrand)
    {
        return $this->getFactory()->createBrandQuery()->filterByIdBrand($idBrand);
    }

    /**
     * @param $idBrand
     *
     * @return mixed|\Orm\Zed\Brand\Persistence\SpyBrandAttributeQuery
     */
    public function queryAttributeByBrandId($idBrand)
    {
        return $this->getFactory()->createBrandAttributeQuery()->filterByFkBrand($idBrand);
    }

    /**
     * @param $idBrand
     *
     * @return mixed|\Orm\Zed\Url\Persistence\SpyUrlQuery
     */
    public function queryUrlByIdBrand($idBrand)
    {
        return $this->getFactory()->createUrlQuery()
            ->joinSpyLocale()
            ->filterByFkResourceBrand($idBrand)
            ->withColumn(SpyLocaleTableMap::COL_LOCALE_NAME);
    }
}

<?php

namespace Pyz\Zed\Brand\Persistence;

use Orm\Zed\Brand\Persistence\SpyBrandAttributeQuery;
use Orm\Zed\Brand\Persistence\SpyBrandQuery;
use Orm\Zed\Url\Persistence\SpyUrlQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\Brand\BrandConfig getConfig()
 * @method \Pyz\Zed\Brand\Persistence\BrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\Brand\Persistence\BrandEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()
 */
class BrandPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @param string|null $modelAlias
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     *
     * @return \Orm\Zed\Brand\Persistence\SpyBrandQuery
     */
    public function createBrandQuery(?string $modelAlias = null, ?Criteria $criteria = null): SpyBrandQuery
    {
        return SpyBrandQuery::create($modelAlias, $criteria);
    }

    /**
     * @param string|null $modelAlias
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     *
     * @return \Orm\Zed\Brand\Persistence\SpyBrandAttributeQuery
     */
    public function createBrandAttributeQuery(?string $modelAlias = null, ?Criteria $criteria = null): SpyBrandAttributeQuery
    {
        return SpyBrandAttributeQuery::create($modelAlias, $criteria);
    }

    /**
     * @param string|null $modelAlias
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     *
     * @return \Orm\Zed\Url\Persistence\SpyUrlQuery
     */
    public function createUrlQuery(?string $modelAlias = null, ?Criteria $criteria = null): SpyUrlQuery
    {
        return SpyUrlQuery::create($modelAlias, $criteria);
    }
}

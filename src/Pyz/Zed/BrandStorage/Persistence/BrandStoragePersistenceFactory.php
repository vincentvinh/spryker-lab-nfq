<?php

namespace Pyz\Zed\BrandStorage\Persistence;

use Orm\Zed\BrandStorage\Persistence\SpyBrandStorageQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Pyz\Zed\BrandStorage\BrandStorageDependencyProvider;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\BrandStorage\BrandStorageConfig getConfig()
 * @method \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainer getQueryContainer()
 */
class BrandStoragePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @param string|null $modelAlias
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     *
     * @return \Orm\Zed\BrandStorage\Persistence\SpyBrandStorageQuery
     */
    public function createBrandStorageQuery(?string $modelAlias = null, ?Criteria $criteria = null): SpyBrandStorageQuery
    {
        return SpyBrandStorageQuery::create($modelAlias, $criteria);
    }

    /**
     * @return mixed
     */
    public function getBrandQueryContainer()
    {
        return $this->getProvidedDependency(BrandStorageDependencyProvider::QUERY_CONTAINER_BRAND);
    }

    /**
     * @return mixed
     */
    public function getLocaleQueryContainer()
    {
        return $this->getProvidedDependency(BrandStorageDependencyProvider::QUERY_CONTAINER_LOCALE);
    }
}

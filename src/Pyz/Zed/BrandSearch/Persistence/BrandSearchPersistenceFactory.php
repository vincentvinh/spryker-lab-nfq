<?php

namespace Pyz\Zed\BrandSearch\Persistence;

use Orm\Zed\BrandSearch\Persistence\SpyBrandSearchQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Pyz\Zed\BrandSearch\BrandSearchDependencyProvider;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\BrandSearch\BrandSearchConfig getConfig()
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainer getQueryContainer()
 */
class BrandSearchPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @param string|null $modelAlias
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     *
     */
    public function createBrandSearchQuery(?string $modelAlias = null, ?Criteria $criteria = null): SpyBrandSearchQuery
    {
        return SpyBrandSearchQuery::create($modelAlias, $criteria);
    }

    /**
     * @return mixed
     */
    public function getBrandQueryContainer()
    {
        return $this->getProvidedDependency(BrandSearchDependencyProvider::QUERY_CONTAINER_BRAND);
    }

    /**
     * @return mixed
     */
    public function getLocaleQueryContainer()
    {
        return $this->getProvidedDependency(BrandSearchDependencyProvider::QUERY_CONTAINER_LOCALE);
    }
}

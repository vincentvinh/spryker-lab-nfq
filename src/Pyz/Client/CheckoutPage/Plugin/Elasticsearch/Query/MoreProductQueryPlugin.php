<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\CheckoutPage\Plugin\Elasticsearch\Query;

use Elastica\Query;
use Elastica\Query\AbstractQuery;
use Elastica\Query\BoolQuery;
use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\SearchContextTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;
use Spryker\Client\Search\Dependency\Plugin\SearchStringGetterInterface;
use Spryker\Client\Search\Dependency\Plugin\SearchStringSetterInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchContextAwareQueryInterface;
use Spryker\Shared\ProductSearch\ProductSearchConfig;
use Spryker\Zed\ContentProductGui\Communication\Table\AbstractProductAbstractTable;
use Elastica\Query\Match;

/**
 * @method \Spryker\Client\Catalog\CatalogFactory getFactory()
 */
class MoreProductQueryPlugin extends AbstractPlugin implements QueryInterface, SearchContextAwareQueryInterface, SearchStringSetterInterface, SearchStringGetterInterface
{
    protected const SOURCE_IDENTIFIER = 'page';

    /**
     * @var string
     */
    protected $searchString;

    /**
     * @var \Elastica\Query
     */
    protected $query;

    protected $limit;

    /**
     * @var \Generated\Shared\Transfer\SearchContextTransfer
     */
    protected $searchContextTransfer;

    public function __construct(int $limit)
    {
        $this->limit = $limit;
        $this->query = $this->createSearchQuery();
    }

    /**
     * {@inheritDoc}
     * - Returns query object for catalog search.
     *
     * @api
     *
     * @return \Elastica\Query
     */
    public function getSearchQuery()
    {
        return $this->query;
    }

    /**
     * {@inheritDoc}
     * - Defines a context for catalog search.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\SearchContextTransfer
     */
    public function getSearchContext(): SearchContextTransfer
    {
        if (!$this->hasSearchContext()) {
            $this->setupDefaultSearchContext();
        }

        return $this->searchContextTransfer;
    }

    /**
     * {@inheritDoc}
     * - Sets a context for catalog search.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SearchContextTransfer $searchContextTransfer
     *
     * @return void
     */
    public function setSearchContext(SearchContextTransfer $searchContextTransfer): void
    {
        $this->searchContextTransfer = $searchContextTransfer;
    }

    /**
     * @param string $searchString
     *
     * @return void
     */
    public function setSearchString($searchString)
    {
        $this->searchString = $searchString;
        $this->query = $this->createSearchQuery();
    }

    /**
     * @return string
     */
    public function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * @return \Elastica\Query
     */
    protected function createSearchQuery()
    {
        $query = new Query();
        $query = $this->addProductSearchToQuery($query);
        $query->setSource([PageIndexMap::SEARCH_RESULT_DATA]);
        $query->setSort([PageIndexMap::SEARCH_RESULT_DATA . '.' . AbstractProductAbstractTable::COL_ID_PRODUCT_ABSTRACT]);
        $query->setSize($this->limit);

        return $query;
    }

    /**
     * @param \Elastica\Query $baseQuery
     *
     * @return \Elastica\Query
     */
    protected function addProductSearchToQuery(Query $baseQuery)
    {
        $matchQuery = (new Match())
                ->setField(PageIndexMap::TYPE, ProductSearchConfig::RESOURCE_TYPE_PRODUCT_ABSTRACT);

        $baseQuery->setQuery($this->createBoolQuery($matchQuery));

        return $baseQuery;
    }

    /**
     * @param \Elastica\Query\AbstractQuery $matchQuery
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function createBoolQuery(AbstractQuery $matchQuery)
    {
        $boolQuery = new BoolQuery();
        $boolQuery->addMust($matchQuery);

        return $boolQuery;
    }

    /**
     * @return void
     */
    protected function setupDefaultSearchContext(): void
    {
        $searchContextTransfer = new SearchContextTransfer();
        $searchContextTransfer->setSourceIdentifier(static::SOURCE_IDENTIFIER);

        $this->searchContextTransfer = $searchContextTransfer;
    }

    /**
     * @return bool
     */
    protected function hasSearchContext(): bool
    {
        return (bool)$this->searchContextTransfer;
    }
}

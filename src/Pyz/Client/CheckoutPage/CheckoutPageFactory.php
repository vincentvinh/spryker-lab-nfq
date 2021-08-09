<?php

namespace Pyz\Client\CheckoutPage;

use Pyz\Client\CheckoutPage\Plugin\Elasticsearch\Query\MoreProductQueryPlugin;
use Spryker\Client\Checkout\CheckoutFactory as SprykerCheckoutFactory;
use Spryker\Client\Search\SearchClientInterface;

class CheckoutPageFactory extends SprykerCheckoutFactory
{
    /**
     * @param int $limit
     *
     * @return \Pyz\Client\CheckoutPage\Plugin\Elasticsearch\Query\MoreProductQueryPlugin
     */
    public function createMoreProductsQueryPlugin(int $limit): MoreProductQueryPlugin
    {
        return new MoreProductQueryPlugin($limit);
    }

    /**
     * @return \Spryker\Client\Search\SearchClientInterface
     */
    public function getSearchClient(): SearchClientInterface
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::CLIENT_SEARCH);
    }

    /**
     * @return mixed
     */
    public function getMoreProductSearchResultFormatters()
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::MORE_PRODUCT_SEARCH_RESULT_FORMATTER_PLUGINS);
    }
}

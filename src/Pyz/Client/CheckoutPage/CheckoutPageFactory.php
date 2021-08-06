<?php

namespace Pyz\Client\CheckoutPage;

use Pyz\Client\CheckoutPage\Plugin\Elasticsearch\Query\MoreProductQueryPlugin;
use Spryker\Client\Checkout\CheckoutFactory as SprykerCheckoutFactory;
use SprykerShop\Yves\CatalogPage\CatalogPageDependencyProvider;
use SprykerShop\Yves\CatalogPage\Dependency\Client\CatalogPageToCatalogClientInterface;

class CheckoutPageFactory extends SprykerCheckoutFactory
{
    /**
     * @param int $limit
     * @return MoreProductQueryPlugin
     */
    public function createMoreProductsQueryPlugin(int $limit): MoreProductQueryPlugin
    {
        return new MoreProductQueryPlugin($limit);
    }

    /**
     * @return \Spryker\Client\Search\SearchClientInterface
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getSearchClient(): \Spryker\Client\Search\SearchClientInterface
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::CLIENT_SEARCH);
    }


    /**
     * @return mixed
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getMoreProductSearchResultFormatters()
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::MORE_PRODUCT_SEARCH_RESULT_FORMATTER_PLUGINS);
    }
}

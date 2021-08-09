<?php

namespace Pyz\Client\CheckoutPage;

use Spryker\Client\Catalog\Plugin\Elasticsearch\ResultFormatter\RawCatalogSearchResultFormatterPlugin;
use Spryker\Client\CatalogPriceProductConnector\Plugin\CurrencyAwareCatalogSearchResultFormatterPlugin;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\LocalizedQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\StoreQueryExpanderPlugin;

class CheckoutPageDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT_SEARCH = 'CLIENT_SEARCH';
    public const MORE_PRODUCT_SEARCH_RESULT_FORMATTER_PLUGINS = 'MORE_PRODUCT_SEARCH_RESULT_FORMATTER_PLUGINS';
    public const PLUGINS_MORE_PRODUCT_SEARCH_QUERY_EXPANDER = 'PLUGINS_MORE_PRODUCT_SEARCH_QUERY_EXPANDER';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container)
    {
        $container = $this->addSearchClient($container);
        $container = $this->addMoreCheckoutSearchResultFormatterPlugins($container);
        $container = $this->addMoreProductSearchQueryExpanderPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSearchClient(Container $container)
    {
        $container[static::CLIENT_SEARCH] = function (Container $container) {
            return $container->getLocator()->search()->client();
        };

        return $container;
    }

    /**
     * @param Container $container
     *
     * @return Container
     */
    public function addMoreCheckoutSearchResultFormatterPlugins(Container $container): Container
    {
        $container[static::MORE_PRODUCT_SEARCH_RESULT_FORMATTER_PLUGINS] = function () {
            return [
                new CurrencyAwareCatalogSearchResultFormatterPlugin(
                    new RawCatalogSearchResultFormatterPlugin()
                ),
            ];
        };

        return $container;
    }

    /**
     * @param Container $container
     *
     * @return Container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException
     */
    protected function addMoreProductSearchQueryExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_MORE_PRODUCT_SEARCH_QUERY_EXPANDER, function () {
            return $this->createMoreProductSearchQueryExpanderPlugins();
        });

        return $container;
    }

    /**
     * @return array
     */
    protected function createMoreProductSearchQueryExpanderPlugins()
    {
        return [
            new StoreQueryExpanderPlugin(),
            new LocalizedQueryExpanderPlugin(),
        ];
    }
}

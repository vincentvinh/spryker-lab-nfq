<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\ProductsRestApi;

use Spryker\Glue\Kernel\Container;
use Spryker\Glue\ProductDiscontinuedRestApi\Plugin\ProductDiscontinuedConcreteProductsResourceExpanderPlugin;
use Spryker\Glue\ProductReviewsRestApi\Plugin\ProductsRestApi\ProductReviewsAbstractProductsResourceExpanderPlugin;
use Spryker\Glue\ProductReviewsRestApi\Plugin\ProductsRestApi\ProductReviewsConcreteProductsResourceExpanderPlugin;
use Spryker\Glue\ProductsRestApi\ProductsRestApiDependencyProvider as SprykerProductsRestApiDependencyProvider;
use Spryker\Zed\Kernel\Container as SprykerContainer;

class ProductsRestApiDependencyProvider extends SprykerProductsRestApiDependencyProvider
{
    public const BRAND_QUERY_CONTAINER = 'BRAND_QUERY_CONTAINER';

    /**
     * @return \Spryker\Glue\ProductsRestApiExtension\Dependency\Plugin\ConcreteProductsResourceExpanderPluginInterface[]
     */
    protected function getConcreteProductsResourceExpanderPlugins(): array
    {
        return [
            new ProductDiscontinuedConcreteProductsResourceExpanderPlugin(),
            new ProductReviewsConcreteProductsResourceExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Glue\ProductsRestApiExtension\Dependency\Plugin\AbstractProductsResourceExpanderPluginInterface[]
     */
    protected function getAbstractProductsResourceExpanderPlugins(): array
    {
        return [
            new ProductReviewsAbstractProductsResourceExpanderPlugin(),
        ];
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addBrandQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addBrandQueryContainer(Container $container): Container
    {
        $container->set(static::BRAND_QUERY_CONTAINER, function (SprykerContainer $container) {
            return $container->getLocator()->brand()->queryContainer();
        });

        return $container;
    }
}

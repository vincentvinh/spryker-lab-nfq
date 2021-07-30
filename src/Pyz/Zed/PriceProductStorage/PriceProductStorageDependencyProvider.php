<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage;

use Orm\Zed\PriceProduct\Persistence\SpyPriceProductStoreQuery;
use Spryker\Zed\AvailabilityGui\Dependency\Facade\AvailabilityToStoreFacadeBridge;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\PriceProductStorage\PriceProductStorageDependencyProvider as SprykerPriceProductStorageDependencyProvider;

/**
 * Class PriceProductStorageDependencyProvider
 *
 * @uses Spryker\Zed\PriceProductStorage\PriceProductStorageDependencyProvider
 * @uses \Spryker\Zed\PriceProductStorage\PriceProductStorageDependencyProvider
 * @package Pyz\Zed\PriceProductStorage
 */
class PriceProductStorageDependencyProvider extends SprykerPriceProductStorageDependencyProvider
{
    public const FACADE_STORE = 'store facade';
    public const PROPEL_QUERY_PRICE_PRODUCT_STORE = 'price product store';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addStoreFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        $container = $this->addPriceProductStoreQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addStoreFacade(Container $container)
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return new AvailabilityToStoreFacadeBridge($container->getLocator()->store()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductStoreQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_PRICE_PRODUCT_STORE, $container->factory(function () {
            return SpyPriceProductStoreQuery::create();
        }));

        return $container;
    }
}

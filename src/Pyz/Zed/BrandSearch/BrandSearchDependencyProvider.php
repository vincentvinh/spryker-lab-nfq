<?php

namespace Pyz\Zed\BrandSearch;

use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class BrandSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    public const QUERY_CONTAINER_LOCALE = 'QUERY_CONTAINER_LOCALE';
    public const QUERY_CONTAINER_BRAND = 'QUERY_CONTAINER_BRAND';
    public const STORE = 'STORE';
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = $this->addFacadeEventBehavior($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addStore($container);
        $container = $this->addUtilEncodingService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        $container = $this->addLocaleQueryContainer($container);
        $container = $this->addBrandQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleQueryContainer(Container $container): Container
    {
        $container->set(static::QUERY_CONTAINER_LOCALE, function (Container $container) {
            return $container->getLocator()->locale()->queryContainer();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addBrandQueryContainer(Container $container): Container
    {
        $container->set(static::QUERY_CONTAINER_BRAND, function (Container $container) {
            return $container->getLocator()->brand()->queryContainer();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStore(Container $container): Container
    {
        $container->set(static::STORE, function (Container $container) {
            return Store::getInstance();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFacadeEventBehavior(Container $container): Container
    {
        $container->set(static::FACADE_EVENT_BEHAVIOR, function (Container $container) {
            return $container->getLocator()->eventBehavior()->facade();
        });

        return $container;
    }

    /**
     * @param Container $container
     * @return Container
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException
     */
    private function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return $container->getLocator()->utilEncoding()->service();
        });

        return $container;
    }
}

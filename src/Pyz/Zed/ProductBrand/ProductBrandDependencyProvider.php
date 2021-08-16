<?php

namespace Pyz\Zed\ProductBrand;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProductBrandDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_LOCALE = 'locale facade';
    public const FACADE_PRODUCT = 'product facade';
    public const FACADE_BRAND = 'brand facade';
    public const FACADE_EVENT = 'facade event';
    public const BRAND_QUERY_CONTAINER = 'brand query container';

    public const SERVICE_UTIL_ENCODING = 'util encoding service';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container->set(static::FACADE_BRAND, function (Container $container) {
            return $container->getLocator()->brand()->facade();
        });
        $container->set(static::FACADE_EVENT, function (Container $container) {
            return $container->getLocator()->event()->facade();
        });
        $container->set(static::FACADE_PRODUCT, function (Container $container) {
            return $container->getLocator()->product()->facade();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container->set(static::FACADE_BRAND, function (Container $container) {
            return $container->getLocator()->brand()->facade();
        });
        $container->set(static::FACADE_LOCALE, function (Container $container) {
            return $container->getLocator()->locale()->facade();
        });
        $container->set(static::BRAND_QUERY_CONTAINER, function (Container $container) {
            return $container->getLocator()->brand()->queryContainer();
        });
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return $container->getLocator()->utilEncoding()->service();
        });

        return $container;
    }
}

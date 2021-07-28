<?php

namespace Pyz\Client\PriceExchange;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class PriceExchangeDependencyProvider extends AbstractDependencyProvider
{

    public const FIXER_SERVICE = 'fixer_service';

    /**
     * @param Container $container
     *
     * @return Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        return $this->addFixerService($container);
    }

    /**
     * @param Container $container
     *
     * @return Container
     */
    protected function addFixerService(Container $container)
    {
        $container[static::FIXER_SERVICE] = function (Container $container) {
            return $container->getLocator()->fixer()->service();
        };

        return $container;
    }
}

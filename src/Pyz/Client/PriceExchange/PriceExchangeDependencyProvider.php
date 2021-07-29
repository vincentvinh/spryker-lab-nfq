<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\PriceExchange;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class PriceExchangeDependencyProvider extends AbstractDependencyProvider
{
    public const FIXER_SERVICE = 'fixer_service';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        return $this->addFixerService($container);
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addFixerService(Container $container)
    {
        $container[static::FIXER_SERVICE] = function (Container $container) {
            return $container->getLocator()->fixer()->service();
        };

        return $container;
    }
}

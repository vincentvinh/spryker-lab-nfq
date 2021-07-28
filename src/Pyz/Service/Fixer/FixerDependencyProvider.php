<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\Fixer;

use GuzzleHttp\Client;
use Spryker\Service\Kernel\AbstractBundleDependencyProvider;
use Spryker\Service\Kernel\Container;

class FixerDependencyProvider extends AbstractBundleDependencyProvider
{
    const HTTP_CLIENT = 'http_client';

    /**
     * @param Container $container
     *
     * @return Container
     */
    public function provideServiceDependencies(Container $container): Container
    {
        $container = $this->addHttpClient($container);

        return $container;
    }

    /**
     * @param Container $container
     *
     * @return Container
     */
    protected function addHttpClient(Container $container): Container
    {
        $container->set(static::HTTP_CLIENT, function (Container $container) {
            return new Client();
        });

        return $container;
    }
}

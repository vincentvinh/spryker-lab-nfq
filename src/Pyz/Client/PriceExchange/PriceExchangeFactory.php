<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\PriceExchange;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use GuzzleHttp\ClientInterface;
use Pyz\Client\PriceExchange\Service\PriceExchangeService;
use Pyz\Client\PriceExchange\Service\PriceExchangeServiceInterface;
use Spryker\Client\Kernel\AbstractFactory;

/**
 * Class PriceExchangeFactory
 * @method PriceExchangeConfig getConfig()
 * @package Pyz\Client\PriceExchange
 */
class PriceExchangeFactory extends AbstractFactory
{
    /**
     * @return PriceExchangeServiceInterface
     */
    public function createPriceExchangeService(): PriceExchangeServiceInterface
    {
        return new PriceExchangeService(
            $this->getHttpClient(),
            $this->getConfig(),
            $this->createPriceExchangeTransfer()
        );
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->getProvidedDependency(PriceExchangeDependencyProvider::HTTP_CLIENT);
    }

    /**
     * @return PriceExchangeTransfer
     */
    private function createPriceExchangeTransfer(): PriceExchangeTransfer
    {
        return new PriceExchangeTransfer();
    }
}

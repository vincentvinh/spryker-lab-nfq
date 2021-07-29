<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\PriceExchange;

use Pyz\Client\PriceExchange\Service\PriceExchangeService;
use Pyz\Client\PriceExchange\Service\PriceExchangeServiceInterface;
use Spryker\Client\Kernel\AbstractFactory;

/**
 * Class PriceExchangeFactory
 *
 * @package Pyz\Client\PriceExchange
 */
class PriceExchangeFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Client\PriceExchange\Service\PriceExchangeServiceInterface
     */
    public function createPriceExchange(): PriceExchangeServiceInterface
    {
        return new PriceExchangeService(
            $this->getFixerService()
        );
    }

    /**
     * @return mixed
     */
    public function getFixerService()
    {
        return $this->getProvidedDependency(PriceExchangeDependencyProvider::FIXER_SERVICE);
    }
}

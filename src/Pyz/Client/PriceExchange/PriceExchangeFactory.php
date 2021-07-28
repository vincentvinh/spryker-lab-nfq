<?php

namespace Pyz\Client\PriceExchange;

use Pyz\Client\PriceExchange\Service\PriceExchangeService;
use Pyz\Client\PriceExchange\Service\PriceExchangeServiceInterface;
use Pyz\Service\Fixer\getFixerInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Shared\Kernel\BundleProxy;

/**
 * Class PriceExchangeFactory
 *
 * @package Pyz\Client\PriceExchange
 */

class PriceExchangeFactory extends AbstractFactory
{

    /**
     * @return PriceExchangeServiceInterface
     */
    public function createPriceExchange(): PriceExchangeServiceInterface
    {
        return new PriceExchangeService(
            $this->getFixerService()
        );
    }

    public function getFixerService()
    {
        return $this->getProvidedDependency(PriceExchangeDependencyProvider::FIXER_SERVICE);
    }
}

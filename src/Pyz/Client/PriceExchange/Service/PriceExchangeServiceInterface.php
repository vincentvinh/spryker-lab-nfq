<?php

declare(strict_types = 1);

namespace Pyz\Client\PriceExchange\Service;

use Generated\Shared\Transfer\PriceExchangeTransfer;

/**
 * Interface ExchangeRateApiInterface
 *
 * @package Pyz\Client\ExchangeRate\Api
 */
interface PriceExchangeServiceInterface
{
    /**
     * @param array $symbols
     *
     * @return PriceExchangeTransfer
     */
    public function getPriceExchanges(array $symbols): PriceExchangeTransfer;
}

<?php

declare(strict_types = 1);

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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
     * Specification:
     * - Get exchange data from fixer.io.
     *
     * @api
     *
     * @param string $base
     * @param string[]|string $symbols
     *
     * @return \Generated\Shared\Transfer\PriceExchangeTransfer
     */
    public function getPriceExchangeData(string $base, array $symbols): PriceExchangeTransfer;
}

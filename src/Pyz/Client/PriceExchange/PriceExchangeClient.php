<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\PriceExchange;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\PriceExchange\PriceExchangeFactory getFactory()
 */
class PriceExchangeClient extends AbstractClient implements PriceExchangeClientInterface
{
    /**
     * Specification:
     * - Get exchange data from fixer.io.
     *
     * @api
     *
     * @param array $symbols
     *
     * @return \Generated\Shared\Transfer\PriceExchangeTransfer
     */
    public function getExchangeData(array $symbols): PriceExchangeTransfer
    {
        return $this->getFactory()->createPriceExchange()->getPriceExchanges($symbols);
    }
}

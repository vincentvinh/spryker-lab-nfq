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
     * @param string $base
     * @param array $symbols
     *
     * @return \Generated\Shared\Transfer\PriceExchangeTransfer
     * @api
     *
     */
    public function getExchangeData(string $base, array $symbols): PriceExchangeTransfer
    {
        return $this->getFactory()->createPriceExchangeService()->getPriceExchangeData($base, $symbols);
    }
}

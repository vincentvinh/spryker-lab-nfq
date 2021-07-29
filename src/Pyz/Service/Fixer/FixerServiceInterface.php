<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\Fixer;

use Generated\Shared\Transfer\PriceExchangeTransfer;

interface FixerServiceInterface
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
    public function getPriceExchanges(array $symbols): PriceExchangeTransfer;
}

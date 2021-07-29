<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\Fixer\Api;

use Generated\Shared\Transfer\PriceExchangeTransfer;

interface GetFixerInterface
{
    /**
     * @param array $symbols
     *
     * @return \Generated\Shared\Transfer\PriceExchangeTransfer
     */
    public function getPriceExchangeData(array $symbols): PriceExchangeTransfer;
}

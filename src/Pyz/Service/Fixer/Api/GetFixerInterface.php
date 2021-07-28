<?php

namespace Pyz\Service\Fixer\Api;

use Generated\Shared\Transfer\PriceExchangeTransfer;

interface GetFixerInterface
{
    /**
     * @param array $symbols
     * @return PriceExchangeTransfer
     */
    public function getPriceExchangeData(array $symbols): PriceExchangeTransfer;
}

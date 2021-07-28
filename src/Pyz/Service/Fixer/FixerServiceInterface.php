<?php

namespace Pyz\Service\Fixer;

use Generated\Shared\Transfer\PriceExchangeTransfer;

interface FixerServiceInterface
{

    /**
     * @param array $symbols
     * @return PriceExchangeTransfer
     */
    public function getPriceExchanges(array $symbols): PriceExchangeTransfer;
}

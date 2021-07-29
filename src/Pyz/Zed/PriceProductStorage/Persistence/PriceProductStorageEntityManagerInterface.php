<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

interface PriceProductStorageEntityManagerInterface
{
    /**
     * @param array $rates
     * @param \Spryker\Zed\Kernel\Persistence\AbstractQueryContainer $queryContainer
     * @param string $store
     *
     * @return mixed
     */
    public function updatePriceData(array $rates, AbstractQueryContainer $queryContainer, string $store);
}

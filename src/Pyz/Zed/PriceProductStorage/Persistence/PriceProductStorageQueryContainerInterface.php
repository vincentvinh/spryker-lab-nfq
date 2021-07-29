<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Persistence;

interface PriceProductStorageQueryContainerInterface
{
    /**
     * @param string $store
     *
     * @return mixed
     */
    public function queryPriceConcreteStorageByStore(string $store);
}

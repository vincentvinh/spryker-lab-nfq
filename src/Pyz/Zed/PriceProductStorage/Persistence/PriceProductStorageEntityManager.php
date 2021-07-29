<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * Class PriceProductStorageEntityManager
 *
 * @package Pyz\Zed\PriceProductStorage\Persistence
 */
class PriceProductStorageEntityManager extends AbstractEntityManager implements PriceProductStorageEntityManagerInterface
{
    /**
     * @param array $rates
     * @param PriceProductStorageQueryContainer $queryContainer
     * @param string $store
     * @return mixed|void
     */
    public function updatePriceData(array $rates, PriceProductStorageQueryContainer $queryContainer, string $store)
    {
        $query = $queryContainer->queryPriceConcreteStorageByStore($store);

        echo "\n[+] Starting update price product concrete storage...";

        /** @var \Orm\Zed\PriceProductStorage\Persistence\Base\SpyPriceProductConcreteStorage $item */
        foreach ($query->find() as $item) {
            $data = $item->getData();
            $originalPrice = $data['prices']['EUR'];

            echo "\n- Product #{$item->getFkProduct()}";
            foreach ($rates as $symbol => $rate) {
                $data['prices'][$symbol] = [
                    'priceData' => null,
                    'GROSS_MODE' => [
                        'DEFAULT' => ($originalPrice['GROSS_MODE']['DEFAULT'] ?? 0) * $rate,
                        'ORIGINAL' => ($originalPrice['GROSS_MODE']['ORIGINAL'] ?? 0) * $rate,
                    ],
                    'NET_MODE' => [
                        'DEFAULT' => ($originalPrice['NET_MODE']['DEFAULT'] ?? 0) * $rate,
                        'ORIGINAL' => ($originalPrice['NET_MODE']['DEFAULT'] ?? 0) * $rate,
                    ],
                ];

                $item->setData($data);
                echo($item->save() > 0 ? " - Success" : " - Fail");
            }
        }
        echo "\n";
    }
}

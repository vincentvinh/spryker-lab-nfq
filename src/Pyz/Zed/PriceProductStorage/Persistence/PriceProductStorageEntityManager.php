<?php

namespace Pyz\Zed\PriceProductStorage\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

class PriceProductStorageEntityManager extends AbstractEntityManager implements PriceProductStorageEntityManagerInterface
{
    public function updatePriceData(array $rates, AbstractQueryContainer $queryContainer, string $store)
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
                    'priceData' => NULL,
                    'GROSS_MODE' => [
                        'DEFAULT' => ($originalPrice['GROSS_MODE']['DEFAULT'] ?? 0) * $rate,
                        'ORIGINAL' => ($originalPrice['GROSS_MODE']['ORIGINAL'] ?? 0) * $rate,
                    ],
                    'NET_MODE' => [
                        'DEFAULT' => ($originalPrice['NET_MODE']['DEFAULT'] ?? 0) * $rate,
                        'ORIGINAL' => ($originalPrice['NET_MODE']['DEFAULT'] ?? 0) * $rate,
                    ]
                ];

                $item->setData($data);
                echo($item->save() > 0 ? " - Success" : " - Fail");
            }
        }
        echo "\n";
    }
}

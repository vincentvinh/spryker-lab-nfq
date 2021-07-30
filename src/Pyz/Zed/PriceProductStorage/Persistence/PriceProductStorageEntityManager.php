<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Persistence;

use Orm\Zed\Currency\Persistence\Map\SpyCurrencyTableMap;
use Orm\Zed\PriceProduct\Persistence\Map\SpyPriceProductStoreTableMap;
use PDO;
use Propel\Runtime\Propel;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * Class PriceProductStorageEntityManager
 *
 * @package Pyz\Zed\PriceProductStorage\Persistence
 */
class PriceProductStorageEntityManager extends AbstractEntityManager implements PriceProductStorageEntityManagerInterface
{
    /**
     * @param array $rates
     * @param \Pyz\Zed\PriceProductStorage\Persistence\PriceProductStorageQueryContainer $queryContainer
     * @param string $store
     *
     * @return void
     */
    public function updatePriceDataConcrete(array $rates, PriceProductStorageQueryContainer $queryContainer, string $store)
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

    /**
     * @param string $currentCurrency
     * @param array $rates
     * @param int $store
     *
     * @return void
     */
    public function updatePriceData(string $currentCurrency, array $rates, int $store)
    {
        $conn = Propel::getConnection();
        foreach ($rates as $symbol => $rate) {
            $stmt = $conn->prepare("
                update " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                set gross_price = A.gross, net_price  = a.net

                from
                (select fk_price_product , gross_price * (:rate::numeric) as gross , net_price * (:rate::numeric) as net
                    from " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                    join " . SpyCurrencyTableMap::TABLE_NAME . " sc on fk_currency = sc.id_currency
                    where fk_store = :store and sc.code = :current
                ) A
                where  A.fk_price_product = sp.fk_price_product
                and  sp.fk_store = :store and sp.fk_currency in (
                    select id_currency from " . SpyCurrencyTableMap::TABLE_NAME . " where code = :symbol
                );
            ");

            $stmt->bindValue(':current', $currentCurrency);
            $stmt->bindValue(':store', $store);
            $stmt->bindValue(':symbol', (string)$symbol);
            $stmt->bindValue(':rate', (float)$rate, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
}

<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

use Orm\Zed\Currency\Persistence\Map\SpyCurrencyTableMap;
use Orm\Zed\PriceProduct\Persistence\Map\SpyPriceProductStoreTableMap;
use PDO;
use Propel\Runtime\Propel;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * Class PriceProductEntityManager
 *
 * @package Pyz\Zed\PriceProduct\Persistence
 * @method \Pyz\Zed\PriceProduct\Persistence\PriceProductPersistenceFactory getFactory()
 */
class PriceProductEntityManager extends AbstractEntityManager implements PriceProductEntityManagerInterface
{
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

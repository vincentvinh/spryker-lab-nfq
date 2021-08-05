<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Currency\Persistence\Map\SpyCurrencyTableMap;
use Orm\Zed\PriceProduct\Persistence\Map\SpyPriceProductDefaultTableMap;
use Orm\Zed\PriceProduct\Persistence\Map\SpyPriceProductStoreTableMap;
use Propel\Runtime\Propel;
use Spryker\Zed\PriceProduct\Persistence\PriceProductEntityManager as SprykerPriceProductEntityManager;

/**
 * Class PriceProductEntityManager
 *
 * @package Pyz\Zed\PriceProduct\Persistence
 * @method \Pyz\Zed\PriceProduct\Persistence\PriceProductPersistenceFactory getFactory()
 */
class PriceProductEntityManager extends SprykerPriceProductEntityManager implements PriceProductEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $currentStore
     * @param array $rates
     *
     * @return void
     */
    public function updatePriceData(StoreTransfer $currentStore, array $rates)
    {
        $conn = Propel::getConnection();
        foreach ($rates as $symbol => $rate) {
            $store = in_array($symbol, $currentStore->getAvailableCurrencyIsoCodes()) ? 1 : 2;
            $sql = "
                with
                    current_currency as (select id_currency as id from " . SpyCurrencyTableMap::TABLE_NAME . " where code = :symbol ),
                    news  as (select nextval('spy_price_product_store_pk_seq') as id, (select id from current_currency) as currency_id , A.fk_price_product, $store , A.gross_price, A.net_price from
                    (select sp.*
                        from " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                        join " . SpyCurrencyTableMap::TABLE_NAME . " sc on fk_currency = sc.id_currency
                        where sc.code = :current ) A
                    left join
                        (select sp.*
                        from " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                        join " . SpyCurrencyTableMap::TABLE_NAME . " sc on fk_currency = sc.id_currency
                        where sc.code = :symbol ) B
                    on A.fk_price_product = B.fk_price_product and A.fk_store = B.fk_store
                    where B.fk_price_product is null),

                    A as (insert into " . SpyPriceProductStoreTableMap::TABLE_NAME . "(id_price_product_store, fk_currency, fk_price_product, fk_store, gross_price, net_price) select * from news),
                    B as (insert into " . SpyPriceProductDefaultTableMap::TABLE_NAME . "(id_price_product_default, fk_price_product_store) select nextval('spy_price_product_default_pk_seq'), id from news),
                    C as (update " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                        set gross_price = A.gross, net_price  = a.net
                        from
                        (select fk_price_product , gross_price * $rate as gross , net_price * $rate as net
                            from " . SpyPriceProductStoreTableMap::TABLE_NAME . " sp
                            join " . SpyCurrencyTableMap::TABLE_NAME . " sc on fk_currency = sc.id_currency
                            where sc.code = :current
                        ) A
                        where  A.fk_price_product = sp.fk_price_product
                        and sp.fk_currency in (
                            select id_currency from " . SpyCurrencyTableMap::TABLE_NAME . " where code = :symbol
                        )
                    )
                select * from news;
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':current', $currentStore->getDefaultCurrencyIsoCode());
            $stmt->bindValue(':symbol', (string)$symbol);

            $stmt->execute();
        }
    }
}

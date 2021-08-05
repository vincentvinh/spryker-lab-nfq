<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Business;

use Generated\Shared\Transfer\EventEntityTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Pyz\Client\PriceExchange\PriceExchangeClient;
use Pyz\Zed\PriceProduct\Persistence\PriceProductEntityManager;
use Pyz\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface;
use Spryker\Zed\Event\Business\EventFacade;

/**
 * Class RateExchangeUpdater
 *
 * @package Pyz\Zed\PriceProduct\Business
 */
class RateExchangeUpdater implements RateExchangeUpdaterInterface
{
    public const PRICE_STORE_EVENT_UPDATE = 'Entity.spy_price_product_store.update';

    /**
     * @var array $rates
     */
    protected $rates;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer $currentStore
     */
    protected $currentStore;

    /**
     * @var \Pyz\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface $queryContainer
     */
    protected $queryContainer;

    /**
     * @var \Pyz\Zed\PriceProduct\Persistence\PriceProductEntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var \Spryker\Zed\Event\Business\EventFacade $eventFacade
     */
    protected $eventFacade;

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $store
     * @param \Pyz\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface $queryContainer
     * @param \Pyz\Zed\PriceProduct\Persistence\PriceProductEntityManager $entityManager
     * @param \Spryker\Zed\Event\Business\EventFacade $eventFacade
     */
    public function __construct(
        StoreTransfer $store,
        PriceProductQueryContainerInterface $queryContainer,
        PriceProductEntityManager $entityManager,
        EventFacade $eventFacade
    ) {
        $this->currentStore = $store;
        $this->queryContainer = $queryContainer;
        $this->entityManager = $entityManager;
        $this->eventFacade = $eventFacade;
    }

    /**
     * @param array $currencies
     *
     * @return void
     */
    public function execute(array $currencies)
    {
        $this->getRates($currencies);
        $this->updateProductPrice();
    }

    /**
     * @param array $currencies
     *
     * @return void
     */
    public function getRates(array $currencies)
    {
        $client = new PriceExchangeClient();
        $currentCurrency = $this->currentStore->getSelectedCurrencyIsoCode();

        $exchangeTransfer = $client->getExchangeData($this->currentStore->getDefaultCurrencyIsoCode(), $currencies);
        $this->rates = $exchangeTransfer->getRates();

        echo "[+] Rates (compare with $currentCurrency):";
        foreach ($this->rates as $symbol => $rate) {
            if ($symbol == $currentCurrency) {
                unset($this->rates[$symbol]);
                continue;
            }
            echo "\n - $symbol: $rate";
        }
    }

    /**
     * Perform update
     *
     * @return void
     */
    public function updateProductPrice()
    {
        $this->entityManager->updatePriceData(
            $this->currentStore,
            $this->rates
        );

        $this->publishEvents();
    }

    /**
     * @return void
     */
    public function publishEvents()
    {
        foreach ($this->rates as $symbol => $rate) {
            $entities = $this->queryContainer->queryPriceProductStoreByCurrency($symbol)->find();
            $transfers = [];
            /** @var \Orm\Zed\PriceProduct\Persistence\SpyPriceProductStore $entity */
            foreach ($entities as $entity) {
                $transfers[] = (new EventEntityTransfer())->setId($entity->getPrimaryKey());
            }

            $this->eventFacade->triggerBulk(static::PRICE_STORE_EVENT_UPDATE, $transfers);
        }
    }
}

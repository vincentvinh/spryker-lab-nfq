<?php

namespace Pyz\Zed\PriceProductStorage\Business;

use Pyz\Client\PriceExchange\PriceExchangeClient;
use Spryker\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface;

class RateExchangeUpdater implements RateExchangeUpdaterInterface{
    /** @var array $rates */
    protected $rates;

    /** @var \Generated\Shared\Transfer\StoreTransfer $currentStore*/
    protected $currentStore;

    /** @var PriceProductQueryContainerInterface $queryContainer */
    protected $queryContainer;

    public function __construct($store, \Pyz\Zed\PriceProductStorage\Persistence\PriceProductStorageQueryContainerInterface $queryContainer)
    {
        $this->currentStore = $store;
        $this->queryContainer = $queryContainer;
    }

    /**
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function execute(){
        $this->getRates();
        $this->updateProductPrice();
    }

    /**
     * get exchange rate
     */
    public function getRates(){
        $client = new PriceExchangeClient();
        $currentCurrency = $this->currentStore->getSelectedCurrencyIsoCode();

        $exchangeTransfer = $client->getExchangeData($this->currentStore->getAvailableCurrencyIsoCodes());
        $this->rates = $exchangeTransfer->getRates();

        echo "[+] Rates (compare with $currentCurrency):";
        foreach ($this->rates as $symbol => $rate){
            if($symbol == $currentCurrency){
                unset($this->rates[$symbol]);
                continue;
            }
            echo "\n - $symbol: $rate";
        }
    }

    /**
     * Perform update
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function updateProductPrice()
    {
        $query = $this->queryContainer->queryPriceConcreteStorageByStore($this->currentStore->getName());

        echo "\n[+] Starting update price product concrete storage...";

        /** @var \Orm\Zed\PriceProductStorage\Persistence\Base\SpyPriceProductConcreteStorage $item */
        foreach ($query->find() as $item){
            $data = $item->getData();
            $originalPrice = $data['prices']['EUR'];

            echo "\n- Product #{$item->getFkProduct()}";
            foreach($this->rates as $symbol => $rate){
                $data['prices'][$symbol] = [
                    'priceData' => NULL,
                    'GROSS_MODE' =>[
                        'DEFAULT' => ($originalPrice['GROSS_MODE']['DEFAULT'] ?? 0) * $rate,
                        'ORIGINAL' => ($originalPrice['GROSS_MODE']['ORIGINAL'] ?? 0) * $rate,
                    ],
                    'NET_MODE' =>[
                        'DEFAULT' => ($originalPrice['NET_MODE']['DEFAULT'] ?? 0) * $rate,
                        'ORIGINAL' => ($originalPrice['NET_MODE']['DEFAULT'] ?? 0) * $rate,
                    ]
                ];

                $item->setData($data);
                echo ($item->save() > 0 ? " - Success" : " - Fail");
            }
        }
        echo "\n";
    }
}

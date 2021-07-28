<?php

namespace Pyz\Zed\PriceProductStorage\Business;

use Pyz\Client\PriceExchange\PriceExchangeClient;
use Spryker\Zed\PriceProductStorage\Persistence\PriceProductStorageQueryContainer;

class RateExchange implements RateExchangeInterface{
    /** @var array $rates */
    protected $rates;

    public function execute(){
        $this->getRates();
        $this->updateProductPrice();
    }

    public function getRates(){
        $client = new PriceExchangeClient();
        $exchangeTransfer = $client->getExchangeData(['VND']); //TODO just hard-code now for symbols
        $this->rates = $exchangeTransfer->getRates();

        echo "[+] Rates:";
        foreach ($this->rates as $symbol => $rate){
            echo "\n - $symbol: $rate";
        }
    }

    public function updateProductPrice()
    {
        $query = (new PriceProductStorageQueryContainer())->queryPriceConcreteStorageByProductIds([])->clear();

        echo "\n[+] Starting update price product concrete storage...";

        /** @var \Orm\Zed\PriceProductStorage\Persistence\Base\SpyPriceProductConcreteStorage $item */
        foreach ($query->find() as $item){
            $data = $item->getData();
            $originalPrice = $data['prices']['EUR'];

            foreach($this->rates as $symbol => $rate){
                echo "\nHandle for product #{$item->getFkProduct()}";
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
            echo "\n";
        }
    }
}

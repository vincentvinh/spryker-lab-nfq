<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Client\PriceExchange\Service;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceExchangeConfigTransfer;
use Generated\Shared\Transfer\PriceExchangeTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Pyz\Client\PriceExchange\PriceExchangeConfig;
use Pyz\Client\PriceExchange\Service\PriceExchangeService;
use Pyz\Shared\PriceExchange\PriceExchangeConstants;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Client
 * @group PriceExchange
 * @group Service
 * @group PriceExchangeServiceTest
 * Add your own group annotations below this line
 */
class PriceExchangeServiceTest extends Unit
{
    /**
     * @var object
     */
    private $getFixerClass;

    /**
     * @var string[]
     */
    private $symbols;

    /**
     * @var object
     */
    private $getFixerClassWrongConfig;

    /**
     * @var string
     */
    private $base;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->symbols = ['VND', 'USD'];
        $this->base = 'VND';
        // create a stub by calling constructor and replacing a method
        $client = $this->createMock(Client::class);

        $priceExchangeConfigTransfer = new PriceExchangeConfigTransfer();
        $priceExchangeConfigTransfer->setApiKey('12312312321');
        $priceExchangeConfigTransfer->setBaseUrl('http://data.fixer.io/api');
        $priceExchangeConfigTransfer->setPriceExchangeMethod('GET');
        $priceExchangeConfigTransfer->setPriceExchangeUri('latest');
        $getFixerConfigSuccess = $this->make(
            PriceExchangeConfig::class,
            [
                'getFixerConfig' => $priceExchangeConfigTransfer,
            ]
        );
        $this->getFixerClass = $this->construct(
            PriceExchangeService::class,
            [
                'client' => $client,
                'fixerConfig' => $getFixerConfigSuccess,
                'priceExchangeTransfer' => new PriceExchangeTransfer(),
            ]
        );
        $priceExchangeConfigTransferFail = new PriceExchangeConfigTransfer();
        $priceExchangeConfigTransferFail->setBaseUrl('wrong_http_base');
        $priceExchangeConfigTransferFail->setApiKey('12312312321');
        $priceExchangeConfigTransferFail->setPriceExchangeMethod('GET');
        $priceExchangeConfigTransferFail->setPriceExchangeUri('latest');
        $getFixerConfigFail = $this->make(
            PriceExchangeConfig::class,
            [
                'getFixerConfig' => $priceExchangeConfigTransferFail,
            ]
        );
        $this->getFixerClassWrongConfig = $this->construct(
            PriceExchangeService::class,
            [
                'client' => $client,
                'fixerConfig' => $getFixerConfigFail,
                'priceExchangeTransfer' => new PriceExchangeTransfer(),
            ]
        );
    }

    /**
     * @return void
     */
    public function testHandleResponseSuccess()
    {
        // create a stub by calling constructor and replacing a method
        $response = new Response(200, [], json_encode([
            'success' => true,
            'timestamp' => 1622538546,
            'base' => $this->base,
            'date' => '2021-06-01',
            'rates' => [
                'VND' => 28189.696825,
                'USD' => 1.223219,
            ],
        ]));
        $priceExchangeTransfer = $this->getFixerClass->handleResponse($response);

        $this->assertInstanceOf(PriceExchangeTransfer::class, $priceExchangeTransfer);
    }

    /**
     * @return void
     */
    public function testHandleResponseFail()
    {
        $this->expectException(BadRequestException::class);
        // create a stub by calling constructor and replacing a method
        $response = new Response(200, [], json_encode([
            'success' => false,
            'error' => [
                'type' => 'internal error',
                'code' => '500',
            ],
        ]));
        $this->getFixerClass->handleResponse($response);
    }

    /**
     * @return void
     */
    public function testGetFixerUrlSuccess()
    {
        $stringUrl = $this->getFixerClass->getFixerUrl($this->base, $this->symbols);

        $this->assertStringContainsString($this->symbols[0], $stringUrl);
    }

    /**
     * @return void
     */
    public function testGetFixerUrlFail()
    {
        $this->expectException(
            BadRequestException::class
        );
        $this->getFixerClassWrongConfig->getFixerUrl($this->base, $this->symbols);
    }
}

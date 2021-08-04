<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\PriceExchange\Service;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Pyz\Client\PriceExchange\PriceExchangeConfig;
use Pyz\Client\PriceExchange\PriceExchangeFactory;
use Spryker\Service\Kernel\AbstractService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * @method PriceExchangeFactory getFactory()
 */
class PriceExchangeService extends AbstractService implements PriceExchangeServiceInterface
{
    public const SYMBOLS = 'symbols';
    public const ACCESS_KEY = 'access_key';
    public const IMPLODE_SEPARATOR = ',';
    public const BASE_SYMBOL = 'base';
    /**
     * @var Client
     */
    private $client;

    /**
     * @var PriceExchangeTransfer
     */
    private $priceExchangeTransfer;

    /**
     * @var PriceExchangeConfig
     */
    private $fixerConfig;

    /**
     * @param Client $client
     * @param PriceExchangeConfig $fixerConfig
     * @param PriceExchangeTransfer $priceExchangeTransfer
     */
    public function __construct(Client $client, PriceExchangeConfig $fixerConfig, PriceExchangeTransfer $priceExchangeTransfer)
    {
        $this->client = $client;
        $this->priceExchangeTransfer = $priceExchangeTransfer;
        $this->fixerConfig = $fixerConfig;
    }

    /**
     * @param string $base
     * @param array $symbols
     *
     * @return PriceExchangeTransfer
     * @throws GuzzleException
     */
    public function getPriceExchangeData(string $base, array $symbols): PriceExchangeTransfer
    {
        $method = $this->fixerConfig->getFixerConfig()->getPriceExchangeMethod();
        $url = $this->getFixerUrl($base, $symbols);

        return $this->handleResponse($this->client->request($method, $url));
    }

    /**
     * @param string $base
     * @param array $symbols
     *
     * @return string
     */
    public function getFixerUrl(string $base, array $symbols): string
    {
        $baseUrl = $this->fixerConfig->getFixerConfig()->getBaseUrl();
        $uri = $this->fixerConfig->getFixerConfig()->getPriceExchangeUri();
        $query = http_build_query([
            static::ACCESS_KEY => $this->fixerConfig->getFixerConfig()->getApiKey(),
            static::BASE_SYMBOL => $base,
            static::SYMBOLS => implode(static::IMPLODE_SEPARATOR, $symbols),
        ]);

        $url = $baseUrl . '/' . $uri . '?' . $query;
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        throw new BadRequestException();
    }

    /**
     * @param ResponseInterface $response
     *
     * @return PriceExchangeTransfer
     *@throws BadRequestException
     *
     */
    public function handleResponse(ResponseInterface $response): PriceExchangeTransfer
    {
        $data = json_decode($response->getBody()->getContents(), true);
        if (empty($data['success'])) {
            throw new BadRequestException($data['error']['type'], $data['error']['code']);
        }
        $this->priceExchangeTransfer->fromArray($data, true);

        return $this->priceExchangeTransfer;
    }
}

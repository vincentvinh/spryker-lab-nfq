<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\Fixer\Api;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Pyz\Service\Fixer\FixerConfig;
use Spryker\Service\Kernel\AbstractService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * @method \Pyz\Service\Fixer\FixerServiceFactory getFactory()
 */
class GetFixer extends AbstractService implements GetFixerInterface
{
    public const SYMBOLS = 'symbols';
    public const ACCESS_KEY = 'access_key';
    public const IMPLODE_SEPARATOR = ',';
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var \Generated\Shared\Transfer\PriceExchangeTransfer
     */
    private $priceExchangeTransfer;

    /**
     * @var \Pyz\Service\Fixer\FixerConfig
     */
    private $fixerConfig;

    /**
     * @param \GuzzleHttp\Client $client
     * @param \Pyz\Service\Fixer\FixerConfig $fixerConfig
     * @param \Generated\Shared\Transfer\PriceExchangeTransfer $priceExchangeTransfer
     */
    public function __construct(Client $client, FixerConfig $fixerConfig, PriceExchangeTransfer $priceExchangeTransfer)
    {
        $this->client = $client;
        $this->priceExchangeTransfer = $priceExchangeTransfer;
        $this->fixerConfig = $fixerConfig;
    }

    /**
     * @param array $symbols
     *
     * @return \Generated\Shared\Transfer\PriceExchangeTransfer
     */
    public function getPriceExchangeData(array $symbols): PriceExchangeTransfer
    {
        $method = $this->fixerConfig->getFixerConfig()->getPriceExchangeMethod();
        $url = $this->getFixerUrl($symbols);

        return $this->handleResponse($this->client->request($method, $url));
    }

    /**
     * @param array $symbols
     *
     * @throws \Symfony\Component\HttpFoundation\Exception\BadRequestException
     *
     * @return string
     */
    private function getFixerUrl(array $symbols): string
    {
        $baseUrl = $this->fixerConfig->getFixerConfig()->getBaseUrl();
        $uri = $this->fixerConfig->getFixerConfig()->getPriceExchangeUri();
        $query = http_build_query([
            static::ACCESS_KEY => $this->fixerConfig->getFixerConfig()->getApiKey(),
            static::SYMBOLS => implode(static::IMPLODE_SEPARATOR, $symbols),
        ]);

        $url = $baseUrl . '/' . $uri . '?' . $query;
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        throw new BadRequestException();
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \Symfony\Component\HttpFoundation\Exception\BadRequestException
     *
     * @return \Generated\Shared\Transfer\PriceExchangeTransfer
     */
    private function handleResponse(ResponseInterface $response): PriceExchangeTransfer
    {
        $data = json_decode($response->getBody()->getContents(), true);
        if (!$data['success']) {
            throw new BadRequestException($data['error']['info'], $data['error']['code']);
        }
        $this->priceExchangeTransfer->fromArray($data, true);

        return $this->priceExchangeTransfer;
    }
}

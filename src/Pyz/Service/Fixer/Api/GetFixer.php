<?php

namespace Pyz\Service\Fixer\Api;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Pyz\Service\Fixer\FixerConfig;
use Pyz\Service\Fixer\FixerServiceFactory;
use Spryker\Service\Kernel\AbstractService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * @method FixerServiceFactory getFactory()
 */
class GetFixer extends AbstractService implements GetFixerInterface
{
    public const SYMBOLS = 'symbols';
    const ACCESS_KEY = 'access_key';
    const IMPLODE_SEPARATOR = ',';
    /**
     * @var Client
     */
    private $client;
    /**
     * @var PriceExchangeTransfer
     */
    private $priceExchangeTransfer;
    /**
     * @var FixerConfig
     */
    private $fixerConfig;

    public function __construct(Client $client, FixerConfig $fixerConfig, PriceExchangeTransfer $priceExchangeTransfer)
    {
        $this->client = $client;
        $this->priceExchangeTransfer = $priceExchangeTransfer;
        $this->fixerConfig = $fixerConfig;
    }

    /**
     * @param array $symbols
     *
     * @return PriceExchangeTransfer
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
     * @param ResponseInterface $response
     *
     * @return PriceExchangeTransfer
     *
     */
    private function handleResponse(ResponseInterface $response): PriceExchangeTransfer
    {
        $data = json_decode($response->getBody()->getContents(), true);
        if (!$data['success']) {
            throw new BadRequestException($data['error']['info'],$data['error']['code']);
        }
        $this->priceExchangeTransfer->fromArray($data, true);

        return $this->priceExchangeTransfer;
    }
}

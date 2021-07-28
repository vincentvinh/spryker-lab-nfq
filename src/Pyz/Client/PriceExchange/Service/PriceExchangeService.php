<?php

declare(strict_types = 1);

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\PriceExchange\Service;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use Pyz\Service\Fixer\FixerService;

/**
 * Class Fixer
 *
 * @package Pyz\Client\PriceExchange\Api\Fixer
 */
class PriceExchangeService implements PriceExchangeServiceInterface
{
    public const STATUS_SUCCESS = 200;
    public const SYMBOLS = 'symbols';

    /**
     * @var \Pyz\Service\Fixer\FixerService
     */
    private $fixerService;

    public function __construct(
        FixerService $fixerService
    ) {
        $this->fixerService = $fixerService;
    }

    /**
     * @param array $symbols
     */
    public function getPriceExchanges(array $symbols): PriceExchangeTransfer
    {
        return $this->fixerService->getPriceExchanges($symbols);
    }
}

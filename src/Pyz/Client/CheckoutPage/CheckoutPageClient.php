<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\CheckoutPage;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\CheckoutPage\CheckoutPageFactory getFactory()
 */
class CheckoutPageClient extends AbstractClient implements CheckoutPageClientInterface
{
    /**
     * @param int $limit
     *
     * @return array
     */
    public function getMoreProducts(int $limit): array
    {
        $searchQuery = $this
                ->getFactory()
                ->createMoreProductsQueryPlugin($limit);

        $searchQueryFormatters = $this
                ->getFactory()
                ->getMoreProductSearchResultFormatters();

        $searchResult = $this->getFactory()
                ->getSearchClient()
                ->search($searchQuery, $searchQueryFormatters);

        return $searchResult['products'];
    }
}

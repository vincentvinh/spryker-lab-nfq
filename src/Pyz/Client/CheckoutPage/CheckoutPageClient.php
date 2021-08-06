<?php

namespace Pyz\Client\CheckoutPage;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\CheckoutPage\CheckoutPageFactory getFactory()
 */
class CheckoutPageClient extends AbstractClient implements CheckoutPageClientInterface
{

    /**
     * @param int $limit
     * @return array
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getMoreProducts(int $limit) : array
    {

        $searchQuery = $this
                ->getFactory()
                ->createMoreProductsQueryPlugin($limit);

        $searchQueryFormatters = $this
                ->getFactory()
                ->getMoreProductSearchResultFormatters();

        $searchResult = $this->getFactory()
                ->getSearchClient()
                ->search($searchQuery,$searchQueryFormatters);

        $new_products = [];
        foreach ($searchResult['products'] as $product) {
            if (!empty($product['add_to_cart_sku']) && count($new_products) < 3) {
                $new_products[$product['id_product_abstract']] = $product;
            }
        }

        return $new_products;
    }
}

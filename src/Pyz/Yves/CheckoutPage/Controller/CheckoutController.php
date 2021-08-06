<?php

namespace Pyz\Yves\CheckoutPage\Controller;

use SprykerShop\Yves\CheckoutPage\Controller\CheckoutController as SprykerShopCheckoutController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\CheckoutPage\CheckoutPageFactory getFactory()
 * @method \Pyz\Client\CheckoutPage\CheckoutPageClient getClient()
 */
class CheckoutController extends SprykerShopCheckoutController
{

    /**
     * @param Request $request
     * @return array|\Spryker\Yves\Kernel\View\View|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function moreAction(Request $request)
    {
        $response = $this->createStepProcess()->process(
            $request
        );

        if (!is_array($response)) {
            return $response;
        }

        $products = $this->getClient()->getMoreProducts(10);

        $response['products'] = $products;

        return $this->view(
            $response,
            $this->getFactory()->getCustomerPageWidgetPlugins(),
            '@CheckoutPage/views/more/more.twig'
        );
    }
}

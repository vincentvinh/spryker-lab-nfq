<?php

namespace Pyz\Zed\BrandSearch\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \Pyz\Zed\BrandSearch\Business\BrandSearchFacade getFacade()
 * @method \Pyz\Zed\BrandSearch\Communication\BrandSearchCommunicationFactory getFactory()
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainer getQueryContainer()
 */
class IndexController extends AbstractController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        return $this->viewResponse([
            'test' => 'Greetings!',
        ]);
    }
}

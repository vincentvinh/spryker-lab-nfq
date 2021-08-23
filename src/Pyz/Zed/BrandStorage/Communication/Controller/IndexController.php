<?php

namespace Pyz\Zed\BrandStorage\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \Pyz\Zed\BrandStorage\Business\BrandStorageFacade getFacade()
 * @method \Pyz\Zed\BrandStorage\Communication\BrandStorageCommunicationFactory getFactory()
 * @method \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainer getQueryContainer()
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

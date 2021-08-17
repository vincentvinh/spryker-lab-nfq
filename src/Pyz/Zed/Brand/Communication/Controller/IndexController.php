<?php

namespace Pyz\Zed\Brand\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method \Pyz\Zed\Brand\Business\BrandFacade getFacade()
 * @method \Pyz\Zed\Brand\Communication\BrandCommunicationFactory getFactory()
 * @method \Pyz\Zed\Brand\Persistence\BrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()
 */
class IndexController extends AbstractController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $table = $this->getFactory()->createBrandTable();

        return [
            'brands' => $table->render(),
        ];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction(): JsonResponse
    {
        return $this->jsonResponse(
            $this->getFactory()->createBrandTable()->fetchData()
        );
    }
}

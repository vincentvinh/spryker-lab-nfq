<?php

namespace Pyz\Zed\Brand\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Brand\Business\BrandFacade getFacade()
 * @method \Pyz\Zed\Brand\Communication\BrandCommunicationFactory getFactory()
 * @method \Pyz\Zed\Brand\Persistence\BrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()
 */
class DeleteController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $idBrand = $this->castId($request->query->get('id-brand'));
        $deleteForm = $this->getFactory()->createDeleteBrandForm();

        return $this->viewResponse([
            'idBrand' => $idBrand,
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function confirmAction(Request $request)
    {
        $deleteForm = $this->getFactory()->createDeleteBrandForm()->handleRequest($request);

        if (!$deleteForm->isSubmitted() || !$deleteForm->isValid()) {
            $this->addErrorMessage('CSRF token is not valid');

            return $this->redirectResponse('/brand');
        }

        $idBrand = $this->castId($request->get('id-brand'));
        $brandTransfer = $this->getFacade()->getBrandById($idBrand);

        $this->getFacade()->delete($brandTransfer);
        $this->addSuccessMessage('Deleted Brand Success');

        return $this->redirectResponse('/brand');
    }
}

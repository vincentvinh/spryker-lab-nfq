<?php

namespace Pyz\Zed\Brand\Communication\Controller;

use Pyz\Shared\Brand\BrandConstants;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Brand\Business\BrandFacade getFacade()
 * @method \Pyz\Zed\Brand\Communication\BrandCommunicationFactory getFactory()
 * @method \Pyz\Zed\Brand\Persistence\BrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()
 */
class ViewController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $brandTransfer = $this->getFacade()->getBrandById($this->castId($request->get(BrandConstants::PARAM_ID_BRAND)));

        if ($brandTransfer === null) {
            $this->addErrorMessage("Brand with id %s doesn't exist", ['%s' => $request->get(BrandConstants::PARAM_ID_BRAND)]);

            return $this->redirectResponse($this->createSuccessRedirectUrl());
        }

        return $this->viewResponse([
            'brand' => $brandTransfer,
            'localizedAttributes' => $brandTransfer->getLocalizedAttributes(),
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return mixed
     */
    protected function getBrandTransferFromForm(FormInterface $form)
    {
        return $form->getData();
    }

    /**
     * @return string
     */
    protected function createSuccessRedirectUrl(): string
    {
        $url = Url::generate('/brand');

        return $url->build();
    }
}

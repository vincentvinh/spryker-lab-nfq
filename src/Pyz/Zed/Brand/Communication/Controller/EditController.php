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
class EditController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $brandTransfer = $this->getFactory()->createBrandEditDataProvider()->getData($this->castId($request->get(BrandConstants::PARAM_ID_BRAND)));

        if ($brandTransfer === null) {
            $this->addErrorMessage("Brand with id %s doesn't exist", ['%s' => $request->get(BrandConstants::PARAM_ID_BRAND)]);

            return $this->redirectResponse($this->createFailRedirectUrl());
        }

        $form = $this->getFactory()->createBrandEditForm($brandTransfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brandTransfer = $this->getBrandTransferFromForm($form);

            $this->getFacade()->update($brandTransfer);
            $this->addSuccessMessage('The brand was edited successfully.');

            return $this->redirectResponse(
                $this->createSuccessRedirectUrl($brandTransfer->getIdBrand())
            );
        }

        return $this->viewResponse([
            'brandForm' => $form->createView(),
            'brandFormTabs' => $this->getFactory()->createBrandFormTabs()->createView(),
            'currentLocale' => $this->getFacade()->getCurrentLocale()->getLocaleName(),
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
     * @param int $idBrand
     *
     * @return string
     */
    protected function createSuccessRedirectUrl(int $idBrand): string
    {
        $url = Url::generate(
            '/brand/edit',
            [
            BrandConstants::PARAM_ID_BRAND => $idBrand,
            ]
        );

        return $url->build();
    }

    /**
     * @return string
     */
    protected function createFailRedirectUrl(): string
    {
        $url = Url::generate('/brand');

        return $url->build();
    }
}

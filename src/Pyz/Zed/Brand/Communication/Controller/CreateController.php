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
class CreateController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $form = $this->getFactory()->createBrandCreateForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brandTransfer = $this->getBrandTransferFromForm($form);
            $this->getFacade()->create($brandTransfer);
            $this->addSuccessMessage('The brand was added successfully.');

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
    protected function createSuccessRedirectUrl(int $idBrand)
    {
        $url = Url::generate(
            '/brand/edit',
            [
            BrandConstants::PARAM_ID_BRAND => $idBrand,
            ]
        );

        return $url->build();
    }
}

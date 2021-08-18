<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Communication\Controller;

use Generated\Shared\Transfer\LocaleTransfer;
use Pyz\Shared\Brand\BrandConstants;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\ProductBrand\Business\ProductBrandFacadeInterface getFacade()
 * @method \Pyz\Zed\ProductBrand\Communication\ProductBrandCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface getRepository()
 */
class AssignController extends AbstractController
{
    public const PARAM_ID_BRAND = 'id-brand';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $idBrand = $this->castId($request->get(BrandConstants::PARAM_ID_BRAND));
        $brandEntity = $this->getBrandEntity($idBrand);

        if (!$brandEntity) {
            return new RedirectResponse('/brand');
        }

        $form = $this->getForm($idBrand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->updateBrandData($form->getData())) {
                $this->addSuccessMessage('The brand was saved successfully.');

                return $this->redirectResponse('/product-brand/assign?id-brand=' . $idBrand);
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addErrorMessage('Please make sure required fields are properly filled in');
        }

        $localeTransfer = $this->getFactory()->getCurrentLocale();
        $brandProductsTable = $this->getBrandProductsTable($idBrand, $localeTransfer);
        $productsTable = $this->getProductsTable($idBrand, $localeTransfer);

//        $brandPath = $brandFacade->getNodePath($idBrand, $localeTransfer); TBD
        $brandPath = $brandEntity->getName();

        return $this->viewResponse([
            'idBrand' => $idBrand,
            'form' => $form->createView(),
            'productBrandsTable' => $brandProductsTable->render(),
            'productsTable' => $productsTable->render(),
            'brandPath' => $brandPath,
            'currentLocale' => $localeTransfer->getLocaleName(),
        ]);
    }

    /**
     * @param int $idBrand
     *
     * @return \Orm\Zed\Brand\Persistence\SpyBrand|null
     */
    protected function getBrandEntity($idBrand)
    {
        $brandEntity = $this->getFactory()
            ->getBrandQueryContainer()
            ->queryBrandById($idBrand)
            ->findOne();
        if (!$brandEntity) {
            $this->addErrorMessage('The brand with id "%s" does not exist.', ['%s' => $idBrand]);

            return null;
        }

        return $brandEntity;
    }

    /**
     * @param int $idBrand
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getForm($idBrand)
    {
        return $this->getFactory()->createAssignForm([
            'id_brand' => $idBrand,
        ]);
    }

    /**
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Pyz\Zed\ProductBrand\Communication\Table\ProductBrandTable
     */
    protected function getBrandProductsTable($idBrand, LocaleTransfer $localeTransfer)
    {
        return $this
            ->getFactory()
            ->createProductBrandTable($localeTransfer, $idBrand);
    }

    /**
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Pyz\Zed\ProductBrand\Communication\Table\ProductTable
     */
    protected function getProductsTable($idBrand, LocaleTransfer $localeTransfer)
    {
        return $this
            ->getFactory()
            ->createProductTable($localeTransfer, $idBrand);
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    protected function updateBrandData(array $data)
    {
        $idBrand = $this->castId($data['id_brand']);

        $this->updateProductBrandMappings($idBrand, $data);

        return true;
    }

    /**
     * @param int $idBrand
     * @param array $data
     *
     * @return void
     */
    protected function updateProductBrandMappings($idBrand, array $data)
    {
        $addProductsMappingCollection = [];
        $removeProductMappingCollection = [];
        if (trim($data['products_to_be_assigned']) !== '') {
            $addProductsMappingCollection = explode(',', $data['products_to_be_assigned']);
        }

        if (trim($data['products_to_be_de_assigned']) !== '') {
            $removeProductMappingCollection = explode(',', $data['products_to_be_de_assigned']);
        }

        if (!empty($removeProductMappingCollection)) {
            $this->getFacade()->removeProductBrandMappings(
                $idBrand,
                $removeProductMappingCollection
            );
        }

        if (!empty($addProductsMappingCollection)) {
            $this->getFacade()->createProductBrandMappings(
                $idBrand,
                $addProductsMappingCollection
            );
        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function productBrandTableAction(Request $request)
    {
        $idBrand = $this->castId($request->get(BrandConstants::PARAM_ID_BRAND));
        $localeTransfer = $this->getFactory()->getCurrentLocale();
        $productBrandTable = $this->getBrandProductsTable($idBrand, $localeTransfer);

        return $this->jsonResponse($productBrandTable->fetchData());
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function productTableAction(Request $request)
    {
        $idBrand = $this->castId($request->get(BrandConstants::PARAM_ID_BRAND));
        $localeTransfer = $this->getFactory()->getCurrentLocale();
        $productTable = $this->getProductsTable($idBrand, $localeTransfer);

        return $this->jsonResponse($productTable->fetchData());
    }
}

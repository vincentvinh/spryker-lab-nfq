<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Communication\Controller;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Brand\Persistence\SpyBrand;
use Pyz\Zed\ProductBrand\Business\ProductBrandFacadeInterface;
use Pyz\Zed\ProductBrand\Communication\ProductBrandCommunicationFactory;
use Pyz\Zed\ProductBrand\Communication\Table\ProductBrandTable;
use Pyz\Zed\ProductBrand\Communication\Table\ProductTable;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method ProductBrandFacadeInterface getFacade()
 * @method ProductBrandCommunicationFactory getFactory()
 * @method ProductBrandQueryContainerInterface getQueryContainer()
 * @method ProductBrandRepositoryInterface getRepository()
 */
class AssignController extends AbstractController
{
    public const PARAM_ID_BRAND = 'id-brand';

    /**
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $idBrand = $this->castId($request->get(ProductBrandTable::PARAM_ID_BRAND));
        $brandEntity = $this->getBrandEntity($idBrand);

        if (!$brandEntity) {
            return new RedirectResponse($this->getFactory()->getBrandFacade()->getBrandListUrl());
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

        $brandFacade = $this->getFactory()->getBrandFacade();
//        $brandPath = $brandFacade->getNodePath($idBrand, $localeTransfer);
        $brandPath = 'qdqwd';
        return $this->viewResponse([
            'idBrand' => $idBrand,
            'form' => $form->createView(),
            'productBrandsTable' => $brandProductsTable->render(),
            'productsTable' => $productsTable->render(),
            'currentBrand' => $brandEntity->toArray(),
            'brandPath' => $brandPath,
            'currentLocale' => $localeTransfer->getLocaleName(),
        ]);
    }

    /**
     * @param int $idBrand
     *
     * @return SpyBrand|null
     */
    protected function getBrandEntity($idBrand)
    {
        $brandEntity = $this->getFactory()
            ->getBrandQueryContainer()
            ->queryBrandById($idBrand);
        if (!$brandEntity) {
            $this->addErrorMessage('The brand with id "%s" does not exist.', ['%s' => $idBrand]);

            return null;
        }

        return $brandEntity;
    }

    /**
     * @param int $idBrand
     *
     * @return FormInterface
     */
    protected function getForm($idBrand)
    {
        return $this->getFactory()->createAssignForm([
            'id_brand' => $idBrand,
        ]);
    }

    /**
     * @param int $idBrand
     * @param LocaleTransfer $localeTransfer
     *
     * @return ProductBrandTable
     */
    protected function getBrandProductsTable($idBrand, LocaleTransfer $localeTransfer)
    {
        return $this
            ->getFactory()
            ->createProductBrandTable($localeTransfer, $idBrand);
    }

    /**
     * @param int $idBrand
     * @param LocaleTransfer $localeTransfer
     *
     * @return ProductTable
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
     * @param int $idBrand
     * @param array $productOrder
     *
     * @return void
     */
    protected function updateProductOrder($idBrand, array $productOrder)
    {
        $this->getFacade()->updateProductMappingsOrder($idBrand, $productOrder);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function productBrandTableAction(Request $request)
    {
        $idBrand = $this->castId($request->get(ProductBrandTable::PARAM_ID_BRAND));
        $localeTransfer = $this->getFactory()->getCurrentLocale();
        $productBrandTable = $this->getBrandProductsTable($idBrand, $localeTransfer);

        return $this->jsonResponse($productBrandTable->fetchData());
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function productTableAction(Request $request)
    {
        $idBrand = $this->castId($request->get(ProductBrandTable::PARAM_ID_BRAND));
        $localeTransfer = $this->getFactory()->getCurrentLocale();
        $productTable = $this->getProductsTable($idBrand, $localeTransfer);

        return $this->jsonResponse($productTable->fetchData());
    }
}

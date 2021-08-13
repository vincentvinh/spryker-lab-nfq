<?php

namespace Pyz\Zed\ProductBrand\Communication;

use Generated\Shared\Transfer\LocaleTransfer;
use Pyz\Zed\ProductBrand\Communication\Table\ProductBrandTable;
use Pyz\Zed\ProductBrand\ProductBrandDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\ProductBrand\ProductBrandConfig getConfig()
 */
class ProductBrandCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getCurrentLocale()
    {
        return $this->getLocaleFacade()
            ->getCurrentLocale();
    }

    /**
     */
    public function getLocaleFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_LOCALE);
    }

    /**
     */
    public function getBrandQueryContainer()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::BRAND_QUERY_CONTAINER);
    }

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     * @param int $idBrand
     *
     */
    public function createProductBrandTable(LocaleTransfer $locale, $idBrand)
    {
        return new ProductBrandTable($this->getQueryContainer(), $this->getUtilEncodingService(), $locale, $idBrand);
    }

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     * @param int $idBrand
     *
     * @return \Spryker\Zed\ProductBrand\Communication\Table\ProductTable
     */
    public function createProductTable(LocaleTransfer $locale, $idBrand)
    {
        return new ProductTable($this->getQueryContainer(), $this->getUtilEncodingService(), $locale, $idBrand);
    }

    /**
     * @return \Spryker\Zed\ProductBrand\Dependency\Service\ProductBrandToUtilEncodingInterface
     */
    public function getUtilEncodingService()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @param array $data
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createAssignForm(array $data)
    {
        return $this->getFormFactory()->create(AssignForm::class, $data, []);
    }

    /**
     * @return \Spryker\Zed\ProductBrand\Dependency\Facade\ProductBrandToBrandBridge
     */
    public function getBrandFacade(): ProductBrandToBrandBridge
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_CATEGORY);
    }
}

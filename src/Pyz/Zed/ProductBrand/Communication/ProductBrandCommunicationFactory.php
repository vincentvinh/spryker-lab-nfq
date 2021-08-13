<?php

namespace Pyz\Zed\ProductBrand\Communication;

use Generated\Shared\Transfer\LocaleTransfer;
use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use Pyz\Zed\ProductBrand\Communication\Form\AssignForm;
use Pyz\Zed\ProductBrand\Communication\Table\ProductBrandTable;
use Pyz\Zed\ProductBrand\Communication\Table\ProductTable;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainer;
use Pyz\Zed\ProductBrand\ProductBrandConfig;
use Pyz\Zed\ProductBrand\ProductBrandDependencyProvider;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method ProductBrandQueryContainer getQueryContainer()
 * @method ProductBrandConfig getConfig()
 */
class ProductBrandCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return LocaleTransfer
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
     * @param LocaleTransfer $locale
     * @param int $idBrand
     *
     */
    public function createProductBrandTable(LocaleTransfer $locale, $idBrand)
    {
        return new ProductBrandTable($this->getQueryContainer(), $this->getUtilEncodingService(), $locale, $idBrand);
    }

    /**
     * @param LocaleTransfer $locale
     * @param int $idBrand
     *
     * @return ProductTable
     */
    public function createProductTable(LocaleTransfer $locale, $idBrand)
    {
        return new ProductTable($this->getQueryContainer(), $this->getUtilEncodingService(), $locale, $idBrand);
    }

    /**
     * @return UtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): UtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @param array $data
     *
     * @return FormInterface
     */
    public function createAssignForm(array $data)
    {
        return $this->getFormFactory()->create(AssignForm::class, $data, []);
    }

    /**
     * @return BrandFacadeInterface
     */
    public function getBrandFacade(): BrandFacadeInterface
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_BRAND);
    }
}

<?php

namespace Pyz\Zed\ProductBrand\Communication;

use Generated\Shared\Transfer\LocaleTransfer;
use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use Pyz\Zed\ProductBrand\Communication\Form\AssignForm;
use Pyz\Zed\ProductBrand\Communication\Table\ProductBrandTable;
use Pyz\Zed\ProductBrand\Communication\Table\ProductTable;
use Pyz\Zed\ProductBrand\ProductBrandDependencyProvider;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\ProductBrand\ProductBrandConfig getConfig()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface getRepository()
 * @method \Pyz\Zed\ProductBrand\Business\ProductBrandFacadeInterface getFacade()
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
     * @return mixed
     */
    public function getLocaleFacade()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return mixed
     */
    public function getBrandQueryContainer()
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::BRAND_QUERY_CONTAINER);
    }

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     * @param int $idBrand
     *
     * @return \Pyz\Zed\ProductBrand\Communication\Table\ProductBrandTable
     */
    public function createProductBrandTable(LocaleTransfer $locale, int $idBrand): ProductBrandTable
    {
        return new ProductBrandTable($this->getQueryContainer(), $this->getUtilEncodingService(), $locale, $idBrand);
    }

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     * @param int $idBrand
     *
     * @return \Pyz\Zed\ProductBrand\Communication\Table\ProductTable
     */
    public function createProductTable(LocaleTransfer $locale, $idBrand)
    {
        return new ProductTable($this->getQueryContainer(), $this->getUtilEncodingService(), $locale, $idBrand);
    }

    /**
     * @return \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): UtilEncodingServiceInterface
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
     * @return \Pyz\Zed\Brand\Business\BrandFacadeInterface
     */
    public function getBrandFacade(): BrandFacadeInterface
    {
        return $this->getProvidedDependency(ProductBrandDependencyProvider::FACADE_BRAND);
    }
}

<?php

namespace Pyz\Zed\Brand\Communication;

use Generated\Shared\Transfer\BrandTransfer;
use Pyz\Zed\Brand\BrandDependencyProvider;
use Pyz\Zed\Brand\Communication\Form\CreateBrandForm;
use Pyz\Zed\Brand\Communication\Form\DataProvider\BrandCreateDataProvider;
use Pyz\Zed\Brand\Communication\Form\DataProvider\BrandEditDataProvider;
use Pyz\Zed\Brand\Communication\Form\DeleteBrandForm;
use Pyz\Zed\Brand\Communication\Table\BrandsTable;
use Pyz\Zed\Brand\Communication\Tabs\BrandFormTabs;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Pyz\Zed\Brand\Persistence\BrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\Brand\Business\BrandFacadeInterface getFacade()
 * @method \Pyz\Zed\Brand\BrandConfig getConfig()
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()
 * @method \Pyz\Zed\Brand\Persistence\BrandEntityManagerInterface getEntityManager()
 */
class BrandCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Pyz\Zed\Brand\Communication\Table\BrandsTable
     */
    public function createBrandTable(): BrandsTable
    {
        return new BrandsTable($this->getFacade(), $this->getQueryContainer());
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createBrandCreateForm(): FormInterface
    {
        $formFactory = $this->getFormFactory();

        return $formFactory->create(
            CreateBrandForm::class,
            $this->createBrandCreateFormDataProvider()->getData(),
            [CreateBrandForm::OPTION_BRAND_QUERY_CONTAINER => $this->getQueryContainer()]
        );
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createBrandEditForm(BrandTransfer $brandTransfer): FormInterface
    {
        $formFactory = $this->getFormFactory();

        return $formFactory->create(
            CreateBrandForm::class,
            $brandTransfer,
            [CreateBrandForm::OPTION_BRAND_QUERY_CONTAINER => $this->getQueryContainer()]
        );
    }

    /**
     * @return \Pyz\Zed\Brand\Communication\Form\DataProvider\BrandCreateDataProvider
     */
    protected function createBrandCreateFormDataProvider(): BrandCreateDataProvider
    {
        return new BrandCreateDataProvider(
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \Pyz\Zed\Brand\Communication\Form\DataProvider\BrandEditDataProvider
     */
    public function createBrandEditDataProvider(): BrandEditDataProvider
    {
        return new BrandEditDataProvider(
            $this->getFacade(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createDeleteBrandForm()
    {
        return $this->getFormFactory()->create(DeleteBrandForm::class);
    }

    /**
     * @return mixed
     */
    protected function getLocaleFacade()
    {
        return $this->getProvidedDependency(BrandDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \Pyz\Zed\Brand\Communication\Tabs\BrandFormTabs
     */
    public function createBrandFormTabs()
    {
        return new BrandFormTabs();
    }
}

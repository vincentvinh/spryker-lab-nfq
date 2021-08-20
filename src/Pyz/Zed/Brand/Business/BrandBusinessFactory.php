<?php

namespace Pyz\Zed\Brand\Business;

use Pyz\Zed\Brand\BrandDependencyProvider;
use Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttribute;
use Pyz\Zed\Brand\Business\Model\BrandUrl\BrandUrl;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\Brand\BrandConfig getConfig()
 * @method \Pyz\Zed\Brand\Persistence\BrandQueryContainer getQueryContainer()
 * @method \Pyz\Zed\Brand\Persistence\BrandEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()()
 */
class BrandBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\Brand\Business\BrandReader
     */
    public function createBrandReader(): BrandReader
    {
        return new BrandReader($this->getRepository(), $this->getQueryContainer());
    }

    /**
     * @return \Pyz\Zed\Brand\Business\BrandWriter
     */
    public function createBrandWriter(): BrandWriter
    {
        return new BrandWriter($this->getEntityManager(), $this->getQueryContainer());
    }

    /**
     * @return \Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttribute
     */
    public function createBrandAttribute(): BrandAttribute
    {
        return new BrandAttribute($this->getQueryContainer());
    }

    /**
     * @return \Pyz\Zed\Brand\Business\Model\BrandUrl\BrandUrl
     */
    public function createBrandUrl(): BrandUrl
    {
        return new BrandUrl(
            $this->getUrlFacade(),
            $this->getQueryContainer()
        );
    }

    /**
     * @return \Pyz\Zed\Brand\Business\Brand
     */
    public function createBrand(): Brand
    {
        return new Brand(
            $this->createBrandWriter(),
            $this->createBrandAttribute(),
            $this->createBrandUrl(),
            $this->getEventFacade()
        );
    }

    /**
     * @return mixed
     */
    public function getLocaleFacade()
    {
        return $this->getProvidedDependency(BrandDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return mixed
     */
    public function getCurrentLocale()
    {
        return $this->getLocaleFacade()->getCurrentLocale();
    }

    /**
     * @return mixed
     */
    public function getUrlFacade()
    {
        return $this->getProvidedDependency(BrandDependencyProvider::FACADE_URL);
    }

    /**
     * @return mixed
     */
    public function getEventFacade()
    {
        return $this->getProvidedDependency(BrandDependencyProvider::FACADE_EVENT);
    }
}

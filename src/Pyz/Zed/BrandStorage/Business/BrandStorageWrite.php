<?php

namespace Pyz\Zed\BrandStorage\Business;

use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandStorageTransfer;
use Orm\Zed\Brand\Persistence\SpyBrand;
use Orm\Zed\BrandStorage\Persistence\SpyBrandStorage;
use Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainerInterface;
use Spryker\Shared\Kernel\Store;

class BrandStorageWrite implements BrandStorageWriteInterface
{
    /**
     * @var \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainerInterface
     */
    protected $brandStorageQueryContainer;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * @param \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainerInterface $brandStorageQueryContainer
     * @param \Spryker\Shared\Kernel\Store $store
     */
    public function __construct(
        BrandStorageQueryContainerInterface $brandStorageQueryContainer,
        Store $store
    ) {
        $this->brandStorageQueryContainer = $brandStorageQueryContainer;
        $this->store = $store;
    }

    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function publish(array $brandIds)
    {
        $brandEntities = $this->getBrands($brandIds);
        $brandStoragesWithIdAndLocales = $this->getBrandStorages($brandIds);

        if (empty($brandEntities)) {
            $this->deleteStorageData($brandStoragesWithIdAndLocales);
        }

        $this->storeData($brandEntities, $brandStoragesWithIdAndLocales);
    }

    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function unpublish(array $brandIds)
    {
        $brandStorages = $this->getBrandStorages($brandIds);
        $this->deleteStorageData($brandStorages);
    }

    /**
     * @param array $brandStoragesWithIdAndLocales
     *
     * @return void
     */
    protected function deleteStorageData(array $brandStoragesWithIdAndLocales)
    {
        foreach ($brandStoragesWithIdAndLocales as $brandStoragesWithIdAndLocale) {
            foreach ($brandStoragesWithIdAndLocale as $brandStorage) {
                $brandStorage->delete();
            }
        }
    }

    /**
     * @param array $brandEntities
     * @param array $brandStorages
     *
     * @return void
     */
    protected function storeData(array $brandEntities, array $brandStorages)
    {
        foreach ($brandEntities as $brandEntity) {
            /** @var SpyBrand $brandEntity */
            /** @var \Generated\Shared\Transfer\BrandStorageTransfer $brand */
            foreach ($brandEntity as $locale => $brand) {
                if (isset($brandStorages[$brand->getIdBrand()][$locale])) {
                    $this->setStoreData($brand, $locale, $brandStorages[$brand->getIdBrand()][$locale]);
                    continue;
                }

                $this->setStoreData($brand, $locale, null);
            }
        }
    }

    /**
     * @param array $brandIds
     *
     * @return array
     */
    protected function getBrands(array $brandIds): array
    {
        $brandEntities = $this->brandStorageQueryContainer->getAllBrandByIds($brandIds);
        $locales = $this->store->getLocales();
        $locales = $this->brandStorageQueryContainer->queryLocalesWithLocaleNames($locales)->toKeyIndex();
        $brandStorageTransfer = [];

        foreach ($brandEntities as $brandEntity) {
            /** @var \Orm\Zed\Brand\Persistence\SpyBrand $brandEntity */
            $brandAttributes = $brandEntity->getAttributes()->toArray();
            foreach ($brandAttributes as $brandAttribute) {
                $localName = $locales[$brandAttribute['FkLocale']];
                $brandAttributeEntity = new BrandLocalizedAttributeTransfer();
                $brandAttributeEntity->fromArray($brandAttribute, true);
                $brandStorageTransfer[$brandEntity->getIdBrand()][$localName->getLocaleName()] = $this->mapToBrandTransfer($brandEntity, $brandAttributeEntity);
            }
        }

        return $brandStorageTransfer;
    }

    /**
     * @param array $brandIds
     *
     * @return array
     */
    protected function getBrandStorages(array $brandIds): array
    {
        $brandStorages = [];
        $brandStorageEntities = $this->brandStorageQueryContainer->getBrandStorageByBrandIds($brandIds)->find();

        foreach ($brandStorageEntities as $brandStorageEntity) {
            /** @var \Orm\Zed\BrandStorage\Persistence\SpyBrandStorage $brandStorageEntity */
            $brandStorages[$brandStorageEntity->getFkBrand()][$brandStorageEntity->getLocale()] = $brandStorageEntity;
        }

        return $brandStorages;
    }

    /**
     * @param \Orm\Zed\Brand\Persistence\SpyBrand $brandTransfer
     * @param \Generated\Shared\Transfer\BrandLocalizedAttributeTransfer $brandLocalizedAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\BrandStorageTransfer
     */
    protected function mapToBrandTransfer(SpyBrand $brandTransfer, BrandLocalizedAttributeTransfer $brandLocalizedAttributesTransfer): BrandStorageTransfer
    {
        $brandStorageTransfer = new BrandStorageTransfer();
        $brandStorageTransfer->setIdBrand($brandTransfer->getIdBrand());
        $brandStorageTransfer->setName($brandTransfer->getName());
        $brandStorageTransfer->setDescription($brandTransfer->getDescription());
        $brandStorageTransfer->setIsHighlight($brandTransfer->getIsHighlight());
        $brandStorageTransfer->setIsSearchable($brandTransfer->getIsSearchable());
        $brandStorageTransfer->setMetaDescription($brandLocalizedAttributesTransfer->getMetaDescription());

        return $brandStorageTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandStorageTransfer $brandStorageTransfer
     * @param string $locale
     * @param \Orm\Zed\BrandStorage\Persistence\SpyBrandStorage|null $spyBrandStorage
     *
     * @return void
     */
    protected function setStoreData(BrandStorageTransfer $brandStorageTransfer, string $locale, ?SpyBrandStorage $spyBrandStorage)
    {
        if (empty($spyBrandStorage)) {
            $spyBrandStorage = new SpyBrandStorage();
        }

        $spyBrandStorage->setData($brandStorageTransfer->toArray());
        $spyBrandStorage->setFkBrand($brandStorageTransfer->getIdBrand());
        $spyBrandStorage->setLocale($locale);
        $spyBrandStorage->save();
    }
}

<?php

namespace Pyz\Zed\Brand\Business\Model\BrandUrl;

use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\UrlTransfer;
use Orm\Zed\Url\Persistence\SpyUrl;
use Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface;
use Spryker\Zed\Url\Business\UrlFacadeInterface;

class BrandUrl implements BrandUrlInterface
{
    /**
     * @var \Spryker\Zed\Url\Business\UrlFacadeInterface
     */
    protected $urlFacade;

    /**
     * @var \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @param \Spryker\Zed\Url\Business\UrlFacadeInterface $urlFacade
     * @param \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface $brandQueryContainer
     */
    public function __construct(
        UrlFacadeInterface $urlFacade,
        BrandQueryContainerInterface $brandQueryContainer
    ) {
        $this->urlFacade = $urlFacade;
        $this->queryContainer = $brandQueryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function create(BrandTransfer $brandTransfer)
    {
        $localizedAttributes = $brandTransfer->getLocalizedAttributes();

        foreach ($localizedAttributes as $localizedAttribute) {
            $locale = $localizedAttribute->requireLocale()->getLocale();
            $this->saveLocalizedUrlBrand($brandTransfer, $locale);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function update(BrandTransfer $brandTransfer)
    {
        $localizedAttributes = $brandTransfer->getLocalizedAttributes();

        foreach ($localizedAttributes as $localizedAttribute) {
            $locale = $localizedAttribute->requireLocale()->getLocale();
            $this->saveLocalizedUrlBrand($brandTransfer, $locale);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function delete(BrandTransfer $brandTransfer)
    {
        $urlEntityCollection = $this->queryContainer->queryUrlByIdBrand($brandTransfer->requireIdBrand()->getIdBrand())->find();

        foreach ($urlEntityCollection as $urlEntity) {
            $urlTransfer = $this->getUrlTransferFromEntity($urlEntity);
            $this->urlFacade->deleteUrl($urlTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return void
     */
    public function saveLocalizedUrlBrand(BrandTransfer $brandTransfer, LocaleTransfer $localeTransfer)
    {
        $urlTransfer = $this->getUrlTransfer($brandTransfer, $localeTransfer);

        $urlBrand = sprintf('/%s/%s', mb_substr($localeTransfer->getLocaleName(), 0, 2), $brandTransfer->getName());
        $urlTransfer->setUrl($urlBrand);

        if ($this->urlFacade->hasUrlCaseInsensitive($urlTransfer)) {
            return;
        }

        if ($urlTransfer->getIdUrl()) {
            $this->urlFacade->updateUrl($urlTransfer);

            return;
        }

        $this->urlFacade->createUrl($urlTransfer);
    }

    /**
     * @param int $idBrand
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return mixed
     */
    protected function findUrlBrand(int $idBrand, LocaleTransfer $localeTransfer)
    {
        return $this->queryContainer->queryUrlByIdBrand($idBrand)
            ->filterByFkLocale($localeTransfer->requireIdLocale()->getIdLocale())
            ->findOne();
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\UrlTransfer
     */
    protected function getUrlTransfer(BrandTransfer $brandTransfer, LocaleTransfer $localeTransfer): UrlTransfer
    {
        $urlTransfer = new UrlTransfer();
        $urlTransfer
            ->setFkLocale($localeTransfer->requireIdLocale()->getIdLocale())
            ->setFkResourceBrand($brandTransfer->requireIdBrand()->getIdBrand());

        $urlEntity = $this->findUrlBrand(
            $brandTransfer->requireIdBrand()->getIdBrand(),
            $localeTransfer
        );

        if ($urlEntity) {
            $urlTransfer->setIdUrl($urlEntity->getIdUrl());
        }

        return $urlTransfer;
    }

    /**
     * @param \Orm\Zed\Url\Persistence\SpyUrl $urlEntity
     *
     * @return \Generated\Shared\Transfer\UrlTransfer
     */
    protected function getUrlTransferFromEntity(SpyUrl $urlEntity)
    {
        $urlTransfer = new UrlTransfer();
        $urlTransfer->fromArray($urlEntity->toArray(), true);

        return $urlTransfer;
    }
}

<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Business\Reader;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface;

class BrandReader implements BrandReaderInterface
{
    /**
     * @var \Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * @var \Pyz\Zed\Brand\Business\BrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @param \Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface $brandRepository
     * @param \Pyz\Zed\Brand\Business\BrandFacadeInterface $brandFacade
     */
    public function __construct(
        ProductBrandRepositoryInterface $brandRepository,
        BrandFacadeInterface $brandFacade
    ) {
        $this->brandRepository = $brandRepository;
        $this->brandFacade = $brandFacade;
    }

    /**
     * @param int $idProductAbstract
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getBrandTransferCollectionByIdProductAbstract(int $idProductAbstract, LocaleTransfer $localeTransfer): BrandCollectionTransfer
    {
        return $this->brandRepository->getBrandTransferCollectionByIdProductAbstract($idProductAbstract, $localeTransfer->getIdLocale());
    }
}

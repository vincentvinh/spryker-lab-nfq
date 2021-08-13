<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Business\Reader;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface;

class BrandReader implements BrandReaderInterface
{
    /**
     * @var ProductBrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * @var BrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @param ProductBrandRepositoryInterface $brandRepository
     * @param BrandFacadeInterface $brandFacade
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
     * @param LocaleTransfer $localeTransfer
     *
     * @return BrandCollectionTransfer
     */
    public function getBrandTransferCollectionByIdProductAbstract(int $idProductAbstract, LocaleTransfer $localeTransfer): BrandCollectionTransfer
    {
        return $this->brandRepository->getBrandTransferCollectionByIdProductAbstract($idProductAbstract, $localeTransfer->getIdLocale());
    }
}

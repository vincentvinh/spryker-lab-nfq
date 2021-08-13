<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Business\Reader;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\ProductBrand\Business\Reader\BrandReaderInterface;

class BrandReader implements BrandReaderInterface
{
    /**
     * @var ProductBrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * @var ProductBrandToBrandInterface
     */
    protected $brandFacade;

    /**
     * @param ProductBrandRepositoryInterface $brandRepository
     * @param ProductBrandToBrandInterface $brandFacade
     */
    public function __construct(
        ProductBrandRepositoryInterface $brandRepository,
        ProductBrandToBrandInterface $brandFacade
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

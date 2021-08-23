<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Communication\Form\DataProvider;

use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Spryker\Zed\Locale\Business\LocaleFacade;

class BrandCreateDataProvider
{
    public const DATA_CLASS = 'data_class';

    /**
     * @var \Spryker\Zed\Locale\Business\LocaleFacade
     */
    protected $localeFacade;

    /**
     * @param \Spryker\Zed\Locale\Business\LocaleFacade $localeFacade
     */
    public function __construct(LocaleFacade $localeFacade)
    {
        $this->localeFacade = $localeFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\BrandTransfer
     */
    public function getData(): BrandTransfer
    {
        $brandTransfer = new BrandTransfer();
        $brandTransfer->setIsHighlight(true);
        $brandTransfer->setIsSearchable(true);

        foreach ($this->localeFacade->getLocaleCollection() as $localTransfer) {
            $brandLocalizedAttributeTransfer = new BrandLocalizedAttributeTransfer();
            $brandLocalizedAttributeTransfer->setLocale($localTransfer);
            $brandTransfer->addLocalizedAttributes($brandLocalizedAttributeTransfer);
        }

        return $brandTransfer;
    }
}

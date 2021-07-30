<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Router;

use Spryker\Yves\Router\RouterConfig as RouterConfigSpryker;

class RouterConfig extends RouterConfigSpryker
{
    /**
     * @return string[]
     */
    public function getAllowedLanguages(): array
    {
        return [
            'de',
            'en',
            'vi',
        ];
    }

    /**
     * @return string[]
     */
    public function getAllowedStores(): array
    {
        return [
          'DE',
          'VN',
        ];
    }
}

<?php

namespace Pyz\Yves\Router;

use Spryker\Yves\Router\RouterConfig AS RouterConfigSpryker;

class RouterConfig extends RouterConfigSpryker
{
    /**
     * @return string[]
     */
    public function getAllowedLanguages() : array
    {
        return [
            'de',
            'en',
            'vi'
        ];
    }

    /**
     * @return string[]
     */
    public function getAllowedStores() :array
    {
        return [
          'DE',
          'VN'
        ];
    }
}

<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Business\Generator;

class UrlPathGenerator implements UrlPathGeneratorInterface
{
    public const BRAND_NAME = 'name';

    /**
     * @param array $brandPath
     *
     * @return string
     */
    public function generate(array $brandPath): string
    {
        $formattedPath = [];

        foreach ($brandPath as $brand) {
            $brandName = trim($brand[self::BRAND_NAME]);

            if ($brandName !== '') {
                $formattedPath[] = mb_strtolower(str_replace(' ', '-', $brandName));
            }
        }

        return '/' . implode('/', $formattedPath);
    }
}

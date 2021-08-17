<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Business\Generator;

interface UrlPathGeneratorInterface
{
    /**
     * @param array $brandPath
     *
     * @return string
     */
    public function generate(array $brandPath): string;
}

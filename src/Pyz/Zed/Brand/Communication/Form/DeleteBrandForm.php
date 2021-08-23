<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;

/**
 * This class is empty because this form needs to implement CSRF protection and all options and form content
 * will be defined in Twig templates.
 *
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()
 * @method \Pyz\Zed\Brand\Business\BrandFacadeInterface getFacade()
 * @method \Pyz\Zed\Brand\BrandConfig getConfig()
 * @method \Pyz\Zed\Brand\Communication\BrandCommunicationFactory getFactory()
 * @method \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface getQueryContainer()
 */
class DeleteBrandForm extends AbstractType
{
}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Communication\Form;

use Pyz\Zed\ProductBrand\Business\ProductBrandFacadeInterface;
use Pyz\Zed\ProductBrand\Communication\ProductBrandCommunicationFactory;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface;
use Pyz\Zed\ProductBrand\ProductBrandConfig;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method ProductBrandFacadeInterface getFacade()
 * @method ProductBrandCommunicationFactory getFactory()
 * @method ProductBrandQueryContainerInterface getQueryContainer()
 * @method ProductBrandConfig getConfig()
 * @method ProductBrandRepositoryInterface getRepository()
 */
class AssignForm extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addIdBrandField($builder)
            ->addProductsToBeAssignedField($builder)
            ->addProductsToBeDeassignedField($builder)
            ->addProductsOrderField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdBrandField(FormBuilderInterface $builder)
    {
        $builder->add('id_brand', HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addProductsToBeAssignedField(FormBuilderInterface $builder)
    {
        $builder->add(
            'products_to_be_assigned',
            HiddenType::class,
            [
                'attr' => [
                    'id' => 'products_to_be_assigned',
                ],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addProductsToBeDeassignedField(FormBuilderInterface $builder)
    {
        $builder->add(
            'products_to_be_de_assigned',
            HiddenType::class,
            [
                'attr' => [
                    'id' => 'products_to_be_de_assigned',
                ],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addProductsOrderField(FormBuilderInterface $builder)
    {
        $builder->add(
            'product_order',
            HiddenType::class,
            [
                'attr' => [
                    'id' => 'product_order',
                ],
            ]
        );

        return $this;
    }
}

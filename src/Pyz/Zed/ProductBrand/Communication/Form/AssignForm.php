<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \Pyz\Zed\ProductBrand\Business\ProductBrandFacadeInterface getFacade()
 * @method \Pyz\Zed\ProductBrand\Communication\ProductBrandCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\ProductBrand\ProductBrandConfig getConfig()
 * @method \Pyz\Zed\ProductBrand\Persistence\ProductBrandRepositoryInterface getRepository()
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

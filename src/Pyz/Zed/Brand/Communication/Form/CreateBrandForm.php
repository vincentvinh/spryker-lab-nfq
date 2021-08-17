<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Communication\Form;

use Generated\Shared\Transfer\BrandTransfer;
use Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
class CreateBrandForm extends AbstractType
{
    public const OPTION_BRAND_QUERY_CONTAINER = 'brand query container';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_LOGO = 'logo';
    public const FIELD_IS_HIGHLIGHTED = 'is_highlight';
    public const FIELD_IS_SEARCHABLE = 'is_searchable';
    public const FIELD_LOCALIZED_ATTRIBUTES = 'localized_attributes';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setRequired(static::OPTION_BRAND_QUERY_CONTAINER);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addBrandNameField($builder, $options[static::OPTION_BRAND_QUERY_CONTAINER])
            ->addDescriptionField($builder)
            ->addLogoField($builder)
            ->addIsHighLightField($builder)
            ->addIsSearchableField($builder)
            ->addLocalizedAttributesForm($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIsHighLightField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_IS_HIGHLIGHTED, CheckboxType::class, [
            'label' => 'HighLight',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface $brandQueryContainer
     *
     * @return $this
     */
    protected function addBrandNameField(FormBuilderInterface $builder, BrandQueryContainerInterface $brandQueryContainer)
    {
        $builder->add(static::FIELD_NAME, TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Callback([
                    'callback' => function ($value, ExecutionContextInterface $context) use ($brandQueryContainer) {
                        $data = $context->getRoot()->getData();

                        $exists = false;
                        if ($data instanceof BrandTransfer) {
                            $exists = $brandQueryContainer
                                    ->queryBrandByName($value)
                                    ->filterByIdBrand($data->getIdBrand(), Criteria::NOT_EQUAL)
                                    ->count() > 0;
                        }

                        if ($exists) {
                            $context->addViolation(sprintf('Brand with name "%s" already in use, please choose another one.', $value));
                        }
                    },
                ]),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIsSearchableField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_IS_SEARCHABLE, CheckboxType::class, [
            'label' => 'Searchable',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDescriptionField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_DESCRIPTION, TextareaType::class, [
            'label' => 'Description',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLogoField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_LOGO, TextType::class, [
            'label' => 'Logo',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLocalizedAttributesForm(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_LOCALIZED_ATTRIBUTES, CollectionType::class, [
            'entry_type' => BrandLocalizedAttributeForm::class,
        ]);

        return $this;
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'brand';
    }

    /**
     * @deprecated Use {@link getBlockPrefix()} instead.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getBlockPrefix();
    }
}

<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Communication\Form;

use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class BrandLocalizedAttributeForm
 *
 * @package Pyz\Zed\Brand\Communication\Form
 * @method \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface getRepository()
 * @method \Pyz\Zed\Brand\Business\BrandFacadeInterface getFacade()
 * @method \Pyz\Zed\Brand\BrandConfig getConfig()
 * @method \Pyz\Zed\Brand\Communication\BrandCommunicationFactory getFactory()
 * @method \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface getQueryContainer()
 */
class BrandLocalizedAttributeForm extends AbstractType
{
    public const FIELD_NAME = 'name';
    public const FIELD_FK_LOCALE = 'fk_locale';
    public const FIELD_LOCALE_NAME = 'locale_name';
    public const FIELD_META_TITLE = 'meta_title';
    public const FIELD_META_DESCRIPTION = 'meta_description';
    public const FIELD_META_KEYWORDS = 'meta_keywords';
    public const FIELD_BRAND_IMAGE_NAME = 'brand_image_name';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => BrandLocalizedAttributeTransfer::class,
        ]);
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
            ->addFkLocaleField($builder)
            ->addLocaleNameField($builder)
            ->addMetaDescriptionField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addFkLocaleField(FormBuilderInterface $builder)
    {
        $builder
            ->add(self::FIELD_FK_LOCALE, HiddenType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'property_path' => 'locale.idLocale',
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLocaleNameField(FormBuilderInterface $builder)
    {
        $builder
            ->add(self::FIELD_LOCALE_NAME, HiddenType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'property_path' => 'locale.localeName',
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMetaDescriptionField(FormBuilderInterface $builder)
    {
        $builder
            ->add(self::FIELD_META_DESCRIPTION, TextareaType::class, [
                'label' => 'Meta Description',
                'required' => false,
                'attr' => [
                    'rows' => 5,
                ],
            ]);

        return $this;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'localizedAttributes';
    }

    /**
     * @deprecated Use {@link getBlockPrefix()} instead.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}

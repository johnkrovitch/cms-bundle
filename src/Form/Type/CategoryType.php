<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Entity\Category;
use App\JK\MediaBundle\Form\Transformer\JQueryUploadTransformer;
use App\JK\MediaBundle\Form\Type\JQueryUploadType;
use App\JK\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Category edit form.
 */
class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'help' => 'cms.category.name_help',
                'label' => 'cms.category.name',
            ])
            ->add('slug', TextType::class, [
                'attr' => [
                    'read-only' => true,
                    'data-help' => 'cms.category.slug_help',
                ],
                'disabled' => true,
                'help' => 'cms.category.slug_help',
                'label' => 'cms.category.slug',
            ])
            ->add('thumbnail', MediaType::class, [
                'help' => 'cms.category.thumbnail_help',
                'label' => 'cms.category.thumbnail',
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'data-help' => 'cms.category.description_help',
                    'rows' => 10,
                ],
                'help' => 'cms.category.description_help',
                'label' => 'cms.category.description',
                'required' => false,
            ])
        ;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'category';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'label' => false,
        ]);
    }
}

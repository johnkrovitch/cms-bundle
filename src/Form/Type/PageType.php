<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'cms.page.edit.title',
                'required' => true,
                'attr' => [
                    'data-help' => 'cms.page.edit.title_help',
                ],
            ])
            ->add('slug', TextType::class, [
                'label' => 'cms.page.edit.slug',
                'disabled' => true,
                'attr' => [
                    'data-help' => 'cms.page.edit.slug_help',
                    'readonly' => true,
                ],
            ])
            ->add('publicationStatus', ChoiceType::class, [
                'choices' => [
                    'cms.publication.draft' => Article::PUBLICATION_STATUS_DRAFT,
                    'cms.publication.validation' => Article::PUBLICATION_STATUS_VALIDATION,
                    'cms.publication.published' => Article::PUBLICATION_STATUS_PUBLISHED,
                ],
                'help' => 'cms.publication.help',
                'label' => 'cms.page.edit.publication_status',
            ])
            ->add('publicationDate', DateTimeType::class)
            ->add('content', \LAG\AdminBundle\Form\Type\TinyMce\TinyMceType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label' => false,
            ])
        ;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'page';
    }
}

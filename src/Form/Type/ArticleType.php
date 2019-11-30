<?php

namespace JK\CmsBundle\Form\Type;

use Doctrine\Common\Collections\Collection;
use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Entity\Tag;
use JK\MediaBundle\Form\Type\MediaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

/**
 * Article form type.
 */
class ArticleType extends AbstractType
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'contenteditable' => 'true',
                    'spellcheck' => 'true',
                    'placeholder' => 'cms.article.title_placeholder',
                ],
                'help' => 'cms.article.title_help',
                'label' => 'cms.article.title',
            ])
            ->add('category', EntityType::class, [
                'class' => 'JK\CmsBundle\Entity\Category',
                'label' => 'cms.article.category',
                'help' => 'cms.article.category_help',
            ])
            ->add('content', TinyMceType::class, [
                'attr' => [
                    'class' => 'tinymce sticky-menu affick affick-top',
                    'data-theme' => 'advanced',
                    'data-help' => 'cms.article.content_help',
                    'contenteditable' => 'true',
                    'spellcheck' => 'true',
                ],
                'label' => 'cms.article.content',
                'required' => false,
                'tinymce' => [
                    'height' => 1000,
                ],
            ])
            ->add('thumbnail', MediaType::class, [
                'label' => 'cms.article.thumbnail',
                'required' => false,
            ])
            ->add('publicationStatus', ChoiceType::class, [
                'choices' => [
                    'cms.publication.draft' => Article::PUBLICATION_STATUS_DRAFT,
                    'cms.publication.validation' => Article::PUBLICATION_STATUS_VALIDATION,
                    'cms.publication.published' => Article::PUBLICATION_STATUS_PUBLISHED,
                ],
                'help' => 'cms.article.publication_status_help',
                'label' => 'cms.article.publication_status',
            ])
            ->add('publicationDate', DateTimeType::class, [
                'help' => 'cms.article.publication_date_help',
                'label' => 'cms.article.publication_date',
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
            ])
            ->add('tags', EntityType::class, [
                'attr' => [
                    'class' => 'select2',
                    'multiple' => 'multiple',
                    'data-url' => $this->router->generate('cms.tag.create_ajax'),
                ],
                'class' => Tag::class,
                'choice_label' => 'name',
                'label' => 'cms.article.tags',
                'help' => 'cms.article.tags_help',
                'multiple' => 'multiple',
                'required' => false,
            ])
            ->add('isCommentable', CheckboxType::class, [
                'help' => 'cms.article.is_commentable_help',
                'label' => 'cms.article.is_commentable',
                'required' => false,
            ])
        ;

        $builder
            ->get('tags')
            ->addModelTransformer(new CallbackTransformer(function ($data) {
                // Fix a bug with Doctrine collection not updated in certain circumstances
                if ($data instanceof Collection) {
                    return $data->toArray();
                }

                return $data;
            }, function ($data) {
                return $data;
            }))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $selector = uniqid('tinymce-');

        $resolver->setDefaults([
            'data_class' => Article::class,
            'tinymce_selector' => $selector,
            'attr' => [
                'id' => $selector,
                'class' => 'article-form',
            ],
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'article';
    }
}
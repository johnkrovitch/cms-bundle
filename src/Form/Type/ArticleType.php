<?php

namespace JK\CmsBundle\Form\Type;

use Doctrine\Common\Collections\Collection;
use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Entity\Category;
use JK\CmsBundle\Entity\Tag;
use JK\CmsBundle\Entity\User;
use JK\CmsBundle\Repository\UserRepository;
use JK\MediaBundle\Form\Type\MediaType;
use JK\MediaBundle\Form\Type\MediaUploadType;
use LAG\AdminBundle\Assets\Registry\ScriptRegistryInterface;
use LAG\AdminBundle\Form\Type\Select2\Select2EntityType;
use LAG\AdminBundle\Form\Type\Select2\Select2Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Article form type.
 */
class ArticleType extends AbstractType
{
    private RouterInterface $router;
    private Security $security;
    private UserRepository $userRepository;

    public function __construct(
        RouterInterface $router,
        Security $security,
        UserRepository $userRepository
    ) {
        $this->router = $router;
        $this->security = $security;
        $this->userRepository = $userRepository;
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
            ->add('category', Select2EntityType::class, [
                'class' => Category::class,
                'label' => 'cms.article.category',
                'help' => 'cms.article.category_help',
            ])
            ->add('content', \LAG\AdminBundle\Form\Type\TinyMce\TinyMceType::class, [
                'attr' => [
                    'class' => 'tinymce sticky-menu affick affick-top',
                    'data-theme' => 'advanced',
                    'data-help' => 'cms.article.content_help',
                    'contenteditable' => 'true',
                    'spellcheck' => 'true',
                    'rows' => 25,
                ],
                'label' => 'cms.article.content',
                'required' => false,
//                'tinymce_options' => [
//                    'height' => 1000,
//                ],
            ])
            ->add('thumbnail', \JK\MediaBundle\Form\Type\MediaType::class, [
                'label' => 'cms.article.thumbnail',
                'help' => 'cms.article.thumbnail_help',
                'required' => false,
                'empty_data' => null,
            ])
            ->add('publicationStatus', Select2Type::class, [
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
            ->add('tags', Select2EntityType::class, [
                'allow_add' => true,
                //'add_endpoint' => $this->router->generate('cms.tag.create_ajax'),
                'attr' => [
                    'class' => 'select2',
                    'multiple' => 'multiple',
                    'data-url' => $this->router->generate('cms.tag.create_ajax'),
                ],
                'by_reference' => false,
                'class' => Tag::class,
                'choice_label' => 'name',
                'create_property_path' => 'name',
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
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $article = $event->getData();

                if (!$article instanceof Article) {
                    return;
                }
                // User should not be null as we are under the cms firewall, the user is fully authenticated
                $user = $this->security->getUser();

                if (!$user instanceof User) {
                    throw new UnexpectedTypeException($user, User::class);
                }
                $user = $this->userRepository->find($user->getId());
                $article->setAuthor($user);
            })
        ;

//        $builder
//            ->get('tags')
//            ->addViewTransformer(new CallbackTransformer(function ($data) {
//                // Fix a bug with Doctrine collection not updated in certain circumstances
//                if ($data instanceof Collection) {
//                    $data = $data->toArray();
//                }
//                dump($data);
//                //die;
//
//                return $data;
//            }, function ($data) {
//                dump($data);
//                die('2');
//                return $data;
//            }))
//        ;
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $selector = uniqid('tinymce-');
//
//        $resolver->setDefaults([
//            'data_class' => Article::class,
//            'tinymce_selector' => $selector,
//            'attr' => [
//                'id' => $selector,
//                'class' => 'article-form',
//            ],
//        ]);
//    }

    public function getBlockPrefix(): string
    {
        return 'article';
    }
}

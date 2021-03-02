<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Property\Access\NullablePropertyAccessor;
use LAG\AdminBundle\Assets\Registry\ScriptRegistryInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/** @deprecated  */
class TinyMceType extends AbstractType
{
    const ALLOWED_PLUGINS = [
        'advlist',
        'anchor',
        'autolink',
        'charmap',
        'code',
        'colorpicker',
        'emoticons',
        'fullscreen',
        'directionality',
        'hr',
        'image',
        'insertdatetime',
        'imagetools',
        'media',
        'nonbreaking',
        'link',
        'lists',
        'pagebreak',
        'print',
        'paste',
        'preview',
        'save',
        'searchreplace',
        'table',
        'textpattern',
        'template',
        'textcolor',
        'wordcount',
        'visualblocks',
        'visualchars',
    ];

    /**
     * @var ScriptRegistryInterface
     */
    private $scriptRegistry;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var Packages
     */
    private $packages;

//    /**
//     * TinyMceType constructor.
//     */
//    public function __construct(
//        ScriptRegistryInterface $scriptRegistry,
//        RouterInterface $router,
//        TranslatorInterface $translator,
//        Packages $packages
//    ) {
//        $this->scriptRegistry = $scriptRegistry;
//        $this->router = $router;
//        $this->translator = $translator;
//        $this->packages = $packages;
//    }

    /**
     * @return string
     */
    public function getParent()
    {
        return TextareaType::class;
    }

    /**
     * Add the required javascript to make tinymce working.
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // Register the cms tinymce here build to avoid merging it with the main cms build
        $this
            ->scriptRegistry
            ->register('footer', '/bundles/jkcms/assets/cms.tinymce.js')
        ;

        $this->setCssClass($view);

        $view->vars['attr']['data-tinymce'] = json_encode($options['tinymce']);
        $view->vars['attr']['class'] .= ' tinymce-textarea';

        $view->vars['attr']['data-add-image-url'] = $this->router->generate('media.add_image_modal');
        $view->vars['attr']['data-edit-image-url'] = $this->router->generate('media.edit_image_modal');
        $view->vars['attr']['data-add-gallery-url'] = $this->router->generate('media.gallery_modal');

        $view->vars['attr']['data-add-image-translation'] = $this->translator->trans('media.image.add');
        $view->vars['attr']['data-gallery-translation'] = $this->translator->trans('media.gallery.add');

        $view->vars['id'] = str_replace('#', '', $options['tinymce']['selector']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'tinymce' => [],
                'attr' => [
                    'rows' => 25,
                ],
            ])
            ->setAllowedTypes('tinymce', 'array')
            ->setNormalizer('tinymce', function (Options $options, $value) {
                $resolver = new OptionsResolver();
                $resolver
                    ->setDefaults([
                        'branding' => false,
                        'language' => 'fr_FR',
                        'selector' => '#'.uniqid('tinymce-'),
                        'toolbar1' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter '
                            .'alignright alignjustify | bullist numlist outdent indent | link image toolbar2: print preview '
                            .'media | forecolor backcolor emoticons code | add_gallery add_image edit_image',
                        'image_advtab' => true,
                        'relative_urls' => false,
                        'convert_urls' => false,
                        'theme' => 'modern',
                        'skin' => 'lightgray',
                        'imagetools_toolbar' => 'rotateleft rotateright | flipv fliph | editimage imageoptions',
                        //'content_css' => $this->packages->getUrl('build/cms.tinymce.content.css'),
                        'content_css' => $this->packages->getUrl('/bundles/jkmedia/assets/media-editor.css'),
                        'body_class' => 'mceForceColors container',
                        'browser_spellcheck' => true,
                        'plugins' => self::ALLOWED_PLUGINS,
                        'height' => 400,
                    ])
                    ->setNormalizer('plugins', function (Options $options, $value) {
                        foreach ($value as $plugin) {
                            if (!in_array($plugin, self::ALLOWED_PLUGINS)) {
                                throw new Exception('Invalid tinymce plugins '.$plugin);
                            }
                        }

                        return $value;
                    })
                    ->setAllowedTypes('plugins', 'array')
                    ->setAllowedTypes('branding', 'boolean')
                    ->setAllowedTypes('selector', 'string')
                    ->setAllowedTypes('theme', 'string')
                    ->setAllowedTypes('skin', 'string')
                    ->setAllowedTypes('toolbar1', 'string')
                    ->setAllowedTypes('image_advtab', 'boolean')
                    ->setAllowedTypes('convert_urls', 'boolean')
                    ->setAllowedTypes('imagetools_toolbar', 'string')
                    ->setAllowedTypes('content_css', 'string')
                    ->setAllowedTypes('body_class', 'string')
                    ->setAllowedTypes('browser_spellcheck', 'boolean')
                ;

                return $resolver->resolve($value);
            })
        ;
    }

    private function setCssClass(FormView $view): void
    {
        $accessor = NullablePropertyAccessor::create();

        $cssClass = [
            'tinymce',
            'tinymce-textarea',
        ];
        $definedClass = [];

        if ($accessor->getValue($view->vars, '[attr][class]')) {
            $definedClass = explode(' ', $accessor->getValue($view->vars, '[attr][class]'));
        }
        $cssClass = array_merge($cssClass, $definedClass);
        $accessor->setValue($view->vars, '[attr][class]', implode(' ', $cssClass));
    }
}

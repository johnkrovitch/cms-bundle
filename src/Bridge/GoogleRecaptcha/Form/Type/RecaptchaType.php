<?php

namespace JK\CmsBundle\Bridge\GoogleRecaptcha\Form\Type;

use JK\CmsBundle\Bridge\GoogleRecaptcha\Form\Constraints\IsRecaptchaValid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecaptchaType extends AbstractType
{
    /**
     * @var
     */
    private $siteKey;

    /**
     * RecaptchaType constructor.
     */
    public function __construct(string $siteKey)
    {
        $this->siteKey = $siteKey;
    }

    /**
     * Add the Recaptcha api script to the html header using the ScriptRegistry.
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['scripts'] = [
            'head' => [
                'https://www.google.com/recaptcha/api.js',
            ],
        ];
        $view->vars['site_key'] = $this->siteKey;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'constraints' => [
                    new IsRecaptchaValid(),
                ],
                'label' => false,
                'mapped' => false,
            ])
        ;
    }
}

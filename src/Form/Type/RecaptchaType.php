<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Form\Constraint\Recaptcha;
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
     *
     * @param string $googleRecaptchaSiteKey
     */
    public function __construct(string $googleRecaptchaSiteKey)
    {
        $this->siteKey = $googleRecaptchaSiteKey;
    }

    /**
     * Add the Recaptcha api script to the html header using the ScriptRegistry.
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
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

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'constraints' => [
                    new Recaptcha(),
                ],
                'label' => false,
                'mapped' => false,
            ])
        ;
    }
}

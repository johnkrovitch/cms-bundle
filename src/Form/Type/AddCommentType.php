<?php

namespace JK\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommentType extends AbstractType
{
    /**
     * @var string
     */
    private $kernelEnvironment;

    public function __construct(string $kernelEnvironment)
    {
        $this->kernelEnvironment = $kernelEnvironment;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // TODO use translation system
        $builder
            ->add('authorName', TextType::class, [
                'label' => 'Votre Nom',
                'attr' => [
                    'placeholder' => 'Votre nom...',
                ],
            ])
            ->add('authorUrl', TextType::class, [
                'label' => 'L\'adresse de votre blog, site...',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Un blog, un site ?',
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre commentaire',
                'attr' => [
                    'placeholder' => 'Laissez votre commentaire ici...',
                ],
            ])
            ->add('notifyNewComments', CheckboxType::class, [
                'label' => 'Etre notifié des nouveaux commentaires',
                'required' => false,
            ])
            ->add('authorEmail', EmailType::class, [
                'label' => 'Votre email (si vous voulez être notifié lorsque des nouveaux commentaires seront postés)',
                'attr' => [
                    'placeholder' => 'Votre email...',
                ],
                'required' => false,
            ])
        ;

        if ('dev' !== $this->kernelEnvironment) {
            $builder->add('recaptcha', RecaptchaType::class, [
                'label' => false,
                'mapped' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label' => false,
            ])
        ;
    }
}

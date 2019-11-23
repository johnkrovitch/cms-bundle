<?php

namespace JK\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'form.username',
            ])
            ->add('email', TextType::class, [
                'label' => 'form.email',
            ]);

        if (!$options['is_creation']) {
            $builder->add('plainPassword', RepeatedType::class, [
                'type' => 'password',
                'first_options' => [
                    'label' => 'form.password',
                ],
                'second_options' => [
                    'label' => 'form.password_confirmation',
                ],
            ]);
        }

        $builder
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_ADMIN' => 'bluebear.cms.administrator',
                    'ROLE_CONTRIBUTOR' => 'bluebear.cms.contributor',
                ],
                'expanded' => true,
                'multiple' => true,
                'translation_domain' => 'messages',
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
                'label' => 'bluebear.cms.enabled',
                'translation_domain' => 'messages',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'is_creation' => false,
            ])
            ->addAllowedTypes('is_creation', 'boolean');
    }
}

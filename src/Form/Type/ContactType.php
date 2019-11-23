<?php

namespace JK\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Contact form.
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'lecomptoir.contact.first_name',
                'attr' => [
                    'placeholder' => 'lecomptoir.contact.first_name_placeholder',
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'lecomptoir.contact.last_name',
                'attr' => [
                    'placeholder' => 'lecomptoir.contact.last_name_placeholder',
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'lecomptoir.contact.email_placeholder',
                ],
            ])
            // anti spam field
            ->add('url', TextType::class, [
                'required' => false,
            ])
            ->add('message', TextareaType::class, [
                'label' => 'lecomptoir.contact.message',
                'attr' => [
                    'rows' => 10,
                    'placeholder' => 'lecomptoir.contact.message_placeholder',
                ],
            ])
            ->add('recaptcha', RecaptchaType::class)
        ;
    }

    /**
     * Return contact form name.
     *
     * @return string
     */
    public function getName()
    {
        return 'contact';
    }
}

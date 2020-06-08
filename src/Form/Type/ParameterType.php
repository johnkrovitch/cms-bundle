<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Entity\Parameters;
use JK\CmsBundle\Exception\Exception;
use JK\MediaBundle\Form\Type\MediaType;
use LAG\AdminBundle\Utils\FormUtils;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                if (!$data) {
                    return;
                }
                $type = FormUtils::convertShortFormType($data->getType());

                if ('media' === $type) {
                    $type = MediaType::class;
                }

                if (!$data instanceof Parameters) {
                    throw new Exception('Invalid data passed to the parameter group type. Expected "'.Parameters::class.'", got "'.get_class($data).'"');
                }
                $form->add('value', $type, [
                    'label' => $data->getLabel(),
                ]);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Parameters::class,
                'label' => false,
            ])
        ;
    }
}

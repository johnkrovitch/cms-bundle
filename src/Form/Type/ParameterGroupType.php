<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Entity\ParameterGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParameterGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('parameters', CollectionType::class, [
            'allow_add' => true,
            'allow_delete' => true,
            'entry_type' => ParameterType::class,
            'label' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => ParameterGroup::class,
            ]);
    }
}

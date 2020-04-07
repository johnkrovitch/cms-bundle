<?php

namespace JK\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'help' => 'cms.menu.name_help',
                'label' => 'cms.menu.name',
            ])
            ->add('items', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => MenuItemType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'help' => 'cms.menu.items_help',
                'label' => 'cms.menu.items',
            ])
        ;
    }
}

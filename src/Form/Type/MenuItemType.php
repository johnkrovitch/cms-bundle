<?php

namespace JK\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $addChildren = false;

        if ($options['nested_level'] <= 2) {
            $addChildren = true;
        }

        $builder
            ->add('name', TextType::class, [
                'help' => 'cms.menu_item.name_help',
                'label' => 'cms.menu_item.name',
            ])
            ->add('position', IntegerType::class, [
                'help' => 'cms.menu_item.position_help',
                'label' => 'cms.menu_item.position',
            ])
        ;

        if ($addChildren) {
            // TODO disabled for now
//            $builder
//                ->add('items', CollectionType::class, [
//                    'allow_add' => true,
//                    'allow_delete' => true,
//                    'attr' => [
//                        'class' => 'collection_nested_level_'.($options['nested_level'] + 1),
//                    ],
//                    'entry_type' => self::class,
//                    'entry_options' => [
//                        'nested_level' => $options['nested_level'] + 1
//                    ],
//                ])
//;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label' => false,
                'nested_level' => 0,
                'attr' => [
                    'class' => 'collection_nested_level_0',
                ],
            ])
            ->setAllowedTypes('nested_level', 'integer')
        ;
    }
}

<?php

namespace JK\CmsBundle\Form\Type;

use App\Entity\Import;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'bluebear.cms.import.wordpress' => Import::IMPORT_TYPE_WORDPRESS,
                ],
            ])
            ->add('file', FileType::class)
        ;
    }
}

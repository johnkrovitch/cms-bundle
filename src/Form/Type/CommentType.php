<?php

namespace JK\CmsBundle\Form\Type;

use LAG\AdminBundle\Admin\Helper\AdminHelperInterface;
use LAG\AdminBundle\Utils\TranslationUtils;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType
{
    /**
     * @var AdminHelperInterface
     */
    private $helper;

    public function __construct(AdminHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $admin = $this->helper->getCurrent();
        $pattern = $admin->getConfiguration()->get('translation')['pattern'];
        $adminName = $admin->getName();

        $builder
            ->add('authorName', TextType::class, [
                'label' => TranslationUtils::getTranslationKey($pattern, $adminName, 'authorName'),
            ])
            ->add('authorEmail', TextType::class, [
                'label' => TranslationUtils::getTranslationKey($pattern, $adminName, 'authorEmail'),
            ])
            ->add('authorUrl', TextType::class, [
                'label' => TranslationUtils::getTranslationKey($pattern, $adminName, 'authorUrl'),
            ])
            ->add('authorIp', TextType::class, [
                'label' => TranslationUtils::getTranslationKey($pattern, $adminName, 'authorIp'),
            ])
            ->add('content', TextareaType::class, [
                'label' => TranslationUtils::getTranslationKey($pattern, $adminName, 'content'),
            ])
            ->add('isApproved', CheckboxType::class, [
                'label' => TranslationUtils::getTranslationKey($pattern, $adminName, 'isApproved'),
                'required' => false,
            ])
            ->add('createdAt', DateType::class, [
                'label' => TranslationUtils::getTranslationKey($pattern, $adminName, 'createdAt'),
                'disabled' => true,
            ])
            ->add('updatedAt', DateType::class, [
                'label' => TranslationUtils::getTranslationKey($pattern, $adminName, 'updatedAt'),
                'disabled' => true,
            ])
        ;
    }
}

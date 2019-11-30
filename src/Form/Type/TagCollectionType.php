<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Form\Transformer\TagCollectionTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TagCollectionType extends AbstractType
{
    /**
     * @var TagCollectionTransformer
     */
    private $transformer;

    /**
     * TagCollectionEmbedType constructor.
     */
    public function __construct(TagCollectionTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer($this->transformer)
        ;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return TextType::class;
    }
}

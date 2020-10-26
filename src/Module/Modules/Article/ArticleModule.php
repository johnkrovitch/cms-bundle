<?php

namespace JK\CmsBundle\Module\Modules\Article;

use JK\CmsBundle\Module\AbstractModule;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleModule extends AbstractModule
{
    public function getName(): string
    {
        return 'article';
    }

    public function configure(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('preview', function (OptionsResolver $previewResolver) {
                $previewResolver
                    ->setRequired('template')
                    ->setAllowedTypes('template', 'string')
                ;
            })
            ->addAllowedTypes('preview', 'array')
        ;
    }
}

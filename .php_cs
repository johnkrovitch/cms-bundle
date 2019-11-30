<?php

$finder = \PhpCsFixer\Finder::create()
    ->in('src/')
;

return \PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'phpdoc_align' => true,
    ])
    ->setFinder($finder)
;

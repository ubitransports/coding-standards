<?php

$finder = new PhpCsFixer\Finder();
$finder->in('src')
       ->in('tests');

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;

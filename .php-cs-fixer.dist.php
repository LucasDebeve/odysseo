<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('tests/Support/_generated')
;

return (new PhpCsFixer\Config())
    ->setParallelConfig(new PhpCsFixer\Runner\Parallel\ParallelConfig(4))
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile('var/cache/.php-cs-fixer.cache')
;
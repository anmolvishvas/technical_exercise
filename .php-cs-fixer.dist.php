<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('node_modules')
    ->exclude('var')
    ->exclude('vendor')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'yoda_style' => false,
        'phpdoc_to_comment' => false,
        'declare_strict_types' => true,
        'trailing_comma_in_multiline' => [
            'after_heredoc' => true,
            'elements' => ['arguments', 'parameters'],
        ],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;

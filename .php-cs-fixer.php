<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude(['bootstrap', 'storage', 'vendor', 'database/migrations'])
    ->name('*.php')
    ->notName('*.blade.php')
    ->notPath('_ide_helper.php')
    ->notPath('server.php')
    ->notPath('public/index.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2'                               => true,
        'array_syntax'                        => ['syntax' => 'short'],
        'blank_line_after_opening_tag'        => true,
        'blank_line_before_return'            => true,
        'cast_spaces'                         => ['space' => 'none'],
        'is_null'                             => ['use_yoda_style' => false],
        'ordered_imports'                     => ['sortAlgorithm' => 'alpha'],
        'no_blank_lines_after_phpdoc'         => true,
        'no_spaces_around_offset'             => true,
        'no_unused_imports'                   => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_order'                        => true,
        'phpdoc_scalar'                       => true,
        'short_scalar_cast'                   => true,
        'single_quote'                        => true,
        'trailing_comma_in_multiline_array'   => true,
    ])
    ->setFinder($finder);

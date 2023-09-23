<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        'app',
        'config',
        'database',
        'lang',
        'routes'
    ])
    ->ignoreVCSIgnored(true)
    ->name('*.php')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP81Migration' => true,
        '@PHP80Migration:risky' => true,
        'align_multiline_comment' => ['comment_type' => 'all_multiline'],
        'array_indentation' => true,
        'blank_line_before_statement' => true,
        'class_attributes_separation' => [
            'elements' => ['method' => 'one', 'property' => 'one']
        ],
        'concat_space' => ['spacing' => 'one'],
        'declare_parentheses' => true,
        'global_namespace_import' => ['import_classes' => true, 'import_constants' => true, 'import_functions' => true],
        'heredoc_to_nowdoc' => true,
        'mb_str_functions' => true,
        'method_chaining_indentation' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'no_multiline_whitespace_around_double_arrow' => false,
        'no_superfluous_elseif' => true,
        'no_unset_on_property' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'operator_linebreak' => ['position' => 'end', 'only_booleans' => true],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property',
                'construct',
                'destruct',
                'magic',
                'method',
            ]
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'no_unused_imports' => true,
        'phpdoc_order' => true,
        'self_accessor' => true,
        'self_static_accessor' => true,
        'single_line_throw' => false,
        'static_lambda' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'trailing_comma_in_multiline' => ['after_heredoc' => true, 'elements' => ['arrays', 'arguments', 'parameters']],
        'use_arrow_functions' => false,
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => true, 'remove_inheritdoc' => true]
    ])
    ->setFinder($finder);

<?php

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->in('app')
    ->in('bootstrap')
    ->in('config')
    ->in('vendor')
    ->in('tests')
    ->name('*.php');

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'binary_operator_spaces' => [
            'align_double_arrow' => true,
            'align_equals' => true
        ],
        'blank_line_before_statement' => true,
        'class_attributes_separation' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_unused_imports' => true,
        'object_operator_without_whitespace' => true,
        'single_blank_line_before_namespace' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline_array' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'visibility_required' => true,
        'whitespace_after_comma_in_array' => true,

        'phpdoc_align' => true,
        'phpdoc_indent' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_to_comment' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_var_without_name' => true,
    ])
    ->setFinder($finder);


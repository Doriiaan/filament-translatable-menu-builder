<?php

declare(strict_types=1);

return [
    'form' => [
        'title' => 'Title',
        'url' => 'URL',
        'linkable_type' => 'Type',
        'linkable_id' => 'ID',
    ],
    'resource' => [
        'name' => [
            'label' => 'Name',
        ],
        'items' => [
            'label' => 'Items',
        ],
    ],
    'actions' => [
        'add' => [
            'label' => 'Add to Menu',
        ],
        'indent' => 'Indent',
        'unindent' => 'Unindent',
    ],
    'items' => [
        'expand' => 'Expand',
        'collapse' => 'Collapse',
        'empty' => [
            'heading' => 'There are no items in this menu.',
        ],
    ],
    'custom_text' => 'Custom Text',
    'open_in' => [
        'label' => 'Open in',
        'options' => [
            'self' => 'Same tab',
            'blank' => 'New tab',
            'parent' => 'Parent tab',
            'top' => 'Top tab',
        ],
    ],
    'notifications' => [
        'created' => [
            'title' => 'Link created',
        ],
    ],
    'panel' => [
        'empty' => [
            'heading' => 'No items found',
            'description' => 'There are no items in this menu.',
        ],
        'pagination' => [
            'previous' => 'Previous',
            'next' => 'Next',
        ],
    ],
];

<?php

declare(strict_types=1);

return [
    'form' => [
        'title' => 'Titel',
        'url' => 'URL',
        'linkable_type' => 'Type',
        'linkable_id' => 'ID',
    ],
    'resource' => [
        'name' => [
            'label' => 'Naam',
        ],
        'items' => [
            'label' => 'Items',
        ],
    ],
    'actions' => [
        'add' => [
            'label' => 'Toevoegen aan menu',
        ],
        'indent' => 'Inspringen',
        'unindent' => 'Uitspringen',
    ],
    'items' => [
        'expand' => 'Uitklappen',
        'collapse' => 'Inklappen',
        'empty' => [
            'heading' => 'Dit menu heeft geen items.',
        ],
    ],
    'custom_link' => 'Aangepaste link',
    'custom_text' => 'Aangepaste tekst',
    'open_in' => [
        'label' => 'Openen op',
        'options' => [
            'self' => 'Huidig tabblad',
            'blank' => 'Nieuw tabblad',
            'parent' => 'Bovenliggend tabblad',
            'top' => 'Hoofdtabblad',
        ],
    ],
    'notifications' => [
        'created' => [
            'title' => 'Link aangemaakt',
        ],
    ],
    'panel' => [
        'empty' => [
            'heading' => 'Geen items gevonden',
            'description' => 'Dit menu heeft geen items.',
        ],
        'pagination' => [
            'previous' => 'Vorige',
            'next' => 'Volgende',
        ],
    ],
];

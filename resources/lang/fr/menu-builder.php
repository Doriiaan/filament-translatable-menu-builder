<?php

declare(strict_types=1);

return [
    'form' => [
        'title' => 'Titre',
        'url' => 'URL',
        'linkable_type' => 'Type',
        'linkable_id' => 'ID',
    ],
    'resource' => [
        'name' => [
            'label' => 'Nom',
        ],
        'items' => [
            'label' => 'Éléments',
        ],
    ],
    'actions' => [
        'add' => [
            'label' => 'Ajouter au menu',
        ],
        'indent' => 'Indenté',
        'unindent' => 'Désindenté',
    ],
    'items' => [
        'expand' => 'Développer',
        'collapse' => 'Réduire',
        'empty' => [
            'heading' => 'Il n’y a aucun élément dans ce menu.',
        ],
    ],
    'custom_link' => 'Lien personnalisé',
    'custom_text' => 'Custom Text',
    'open_in' => [
        'label' => 'Ouvrir dans',
        'options' => [
            'self' => 'Même onglet',
            'blank' => 'Nouvel onglet',
            'parent' => 'Onglet parent',
            'top' => 'Onglet supérieur',
        ],
    ],
    'notifications' => [
        'created' => [
            'title' => 'Lien créé',
        ],
    ],
    'panel' => [
        'empty' => [
            'heading' => 'Aucun élément trouvé',
            'description' => 'Il n’y a aucun élément dans ce menu.',
        ],
        'pagination' => [
            'previous' => 'Précédent',
            'next' => 'Suivant',
        ],
    ],
];

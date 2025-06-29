<?php

declare(strict_types=1);

return [
    'form' => [
        'title' => 'Tiêu đề',
        'url' => 'URL',
        'linkable_type' => 'Loại',
        'linkable_id' => 'ID',
    ],
    'resource' => [
        'name' => [
            'label' => 'Tên',
        ],
        'items' => [
            'label' => 'Mục',
        ],
    ],
    'actions' => [
        'add' => [
            'label' => 'Thêm vào Menu',
        ],
        'indent' => 'Thụt lề',
        'unindent' => 'Thụt lề ngược',
    ],
    'items' => [
        'expand' => 'Mở rộng',
        'collapse' => 'Thu gọn',
        'empty' => [
            'heading' => 'Không có mục nào trong menu này.',
        ],
    ],
    'custom_link' => 'Liên kết Tùy chỉnh',
    'custom_text' => 'Custom Text',
    'open_in' => [
        'label' => 'Mở trong',
        'options' => [
            'self' => 'Cùng tab',
            'blank' => 'Tab mới',
            'parent' => 'Tab cha',
            'top' => 'Tab trên cùng',
        ],
    ],
    'notifications' => [
        'created' => [
            'title' => 'Liên kết đã được tạo',
        ],
    ],
    'panel' => [
        'empty' => [
            'heading' => 'Không tìm thấy mục nào',
            'description' => 'Không có mục nào trong menu này.',
        ],
        'pagination' => [
            'previous' => 'Trước',
            'next' => 'Tiếp',
        ],
    ],
];

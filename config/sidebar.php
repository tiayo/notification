<?php

return [

    'nav_0' => [
        'name' => '控制台',
        'icon' => 'home',
        'route' => 'admin',
    ],

    'nav_4' => [
        'name' => '我的文章',
        'icon' => 'files-o',
        'child' => [
            'nav_4_1' => [
                'name' => '全部文章',
                'route' => 'article_list'
            ],
            'nav_4_2' => [
                'name' => '添加文章',
                'route' => 'article_add',
            ],
        ]
    ],

    'nav_1' => [
        'name' => '我的任务',
        'icon' => 'cubes',
        'child' => [
            'nav_1_1' => [
                'name' => '全部任务',
                'route' => 'task_page_simple'
            ],
            'nav_1_2' => [
                'name' => '添加任务',
                'route' => 'task_add_simple'
            ],
        ]
    ],

    'nav_2' => [
        'name' => '我的订单',
        'icon' => 'sitemap',
        'child' => [
            'nav_2_1' => [
                'name' => '赞助我们',
                'route' => 'sponsor'
            ],
            'nav_2_2' => [
                'name' => '全部订单',
                'route' => 'order_page_simple'
            ],
        ]
    ],

    'nav_5' => [
        'name' => '会员中心',
        'icon' => 'users',
        'child' => [
            'nav_5_1' => [
                'name' => '我的资料',
                'route' => 'me_view'
            ],
            'nav_5_2' => [
                'name' => '我的评论',
                'route' => 'comment_page_simple'
            ],
            'nav_5_3' => [
                'name' => '我的消息',
                'icon' => '',
                'route' => 'message_received_page_simple'
            ],
        ]
    ],

    'nav_6' => [
        'name' => '我的账本',
        'icon' => 'money',
        'child' => [
            'nav_6_1' => [
                'name' => '设置账本',
                'route' => 'accounting_setup'
            ],
            'nav_6_2' => [
                'name' => '添加消费记录',
                'route' => 'accounting_add'
            ],
            'nav_6_3' => [
                'name' => '全部消费记录',
                'route' => 'accounting_view_simple'
            ],
            'nav_6_4' => [
                'name' => '账单',
                'route' => 'accounting_statistics'
            ],
        ]
    ],

    'nav_3' => [
        'name' => '管理操作',
        'icon' => 'columns',
        'can' => 'admin',
        'child' => [
            'nav_3_1' => [
                'name' => '管理分类',
                'route' => 'category_simple'
            ],
            'nav_3_2' => [
                'name' => '管理退款',
                'route' => 'refund_page_simple'
            ],
            'nav_3_3' => [
                'name' => '生成页面',
                'route' => 'generate_view'
            ],
        ]
    ],
];
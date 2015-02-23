<?php

return [
    'home' => [
        'name' => 'Home',
        'icon' => 'fa fa-home fa-fw',
        'url' => '/admin/dashboard',
    ],

    'submissions' => [
        'name' => 'Submissions',
        'icon' => 'fa fa-paperclip fa-fw',
        'url' => '#',
        'items' => [
            'lists' => [
                'name' => 'Lists',
                'url' => '/admin/submissions/lists',
            ]
        ],
    ],

    'tagging' => [
        'name' => 'Tagging',
        'icon' => 'fa fa-edit fa-fw',
        'url' => '#',
        'roles' => ['superuser', 'supervisor', 'agent'],
        'items' => [

            'receiving' => [
                'name'      => 'Receiving',
                'url'       => '/admin/tagging/receiving',
            ],
            'submitted' => [
                'name'      => 'Submitting',
                'url'       => '/admin/tagging/submitting',
            ],
            'processing' => [
                'name'      => 'Processing',
                'url'       => '/admin/tagging/processing',
            ],
            'releasing' => [
                'name'      => 'Releasing',
                'url'       => '/admin/tagging/releasing',
            ],
            'dispatching' => [
                'name'      => 'Dispatching',
                'url'       => '/admin/tagging/dispatching',
            ],
            'delivered' => [
                'name'      => 'Delivered',
                'url'       => '/admin/tagging/delivered',
            ],

            'incomplete' => [
                'name'      => 'Incomplete',
                'url'       => '/admin/tagging/incomplete',
            ],
            'damaged' => [
                'name'      => 'Damaged',
                'url'       => '/admin/tagging/damaged',
            ],
        ],
    ],

    'reports' => [
        'name' => 'Reports',
        'icon' => 'fa fa-table fa-fw',
        'url' => '#',
        'items' => [
            'report1' => [
                'name' => '<span style="font-size:11px;">Import Incoming Submissions</span>',
                'url' => '/admin/report/import-incoming-submission',
            ],
            'report2' => [
                'name' => 'Import Delivered Copy',
                'url' => '/admin/report/import-delivered-copy',
            ],
        ],
    ],



    // ----------------------------------------------------------------
    // DO NOT EDIT BELOW THIS AREA IF YOU DONT KNOW WHAT YOU ARE DOING
    // ----------------------------------------------------------------
    'settings' => [
        'name' => 'Settings',
        'icon' => 'fa fa-cogs fa-fw',
        'url' => '#',
        'items' => [
            'change_password' => [
                'name' => 'Change Password',
                'url' => '/admin/settings/change-password',
            ],
        ],
    ],

    'users' => [
        'name' => 'Users',
        'icon' => 'fa fa-users fa-fw',
        'url' => '#',
        'roles' => ['superuser'],
        'items' => [
            'lists' => [
                'name' => 'Lists',
                'url' => '/admin/user/lists',
            ],
        ],
    ],

    'roles_nav' => [
        'name' => 'Roles',
        'icon' => 'fa fa-list fa-fw',
        'url' => '#',
        'roles' => ['superuser'],
        'items' => [
            'lists' => [
                'name' => 'Lists',
                'url' => '/admin/role/lists',
            ],
        ],
    ],

];
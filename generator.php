<?php
    require_once('vendor/autoload.php');

    use TaskForce\utils\CsvToSqlImporter;

    $datasets_dir = "{$_SERVER['DOCUMENT_ROOT']}/data/";

    $datasets_files = [
        'cities.csv' => [
            'columns' => [
                'city', 'lt', 'lg'
            ],
            'dependencies' => []
        ],

        'categories.csv' => [
            'columns' => [
                'name', 'icon'
            ],
            'dependencies' => []
        ],

        'users.csv' => [
            'columns' => [
                'email', 'name', 'password', 'dt_add', 'city',
            ],
            'dependencies' => [
                'city' => 'cities.csv',
            ]
        ],

        'profiles.csv' => [
            'columns' => [
                'address', 'bd', 'about', 'phone', 'skype', 'user_id'
            ],
            'dependencies' => [
                'user_id' => 'users.csv',
            ]
        ],

        'tasks.csv' => [
            'columns' => [
                'dt_add', 'category_id', 'description', 'expire',
                'name', 'address', 'budget', 'lt', 'lg',
                'customer_id', 'executor_id'
            ],
            'dependencies' => [
                'customer_id' => 'users.csv',
                'executor_id' => 'users.csv',
                'category_id' => 'categories.csv'
            ],
        ],

        'opinions.csv' => [
            'columns' => [
                'dt_add', 'rate', 'description', 'sender_id', 'receiver_id', 'task_id',
            ],
            'dependencies' => [
                'sender_id' => 'users.csv',
                'receiver_id' => 'users.csv',
                'task_id' => 'tasks.csv'
            ]
        ],

        'replies.csv' => [
            'columns' => [
                'dt_add', 'rate', 'description', 'sender_id', 'receiver_id', 'task_id',
            ],
            'dependencies' => [
                'sender_id' => 'users.csv',
                'receiver_id' => 'users.csv',
                'task_id' => 'tasks.csv'
            ]
        ],
    ];

    foreach ($datasets_files as $file => $data){
        $CsvToSqlImporter = new CsvToSqlImporter(
            $datasets_dir.$file,
            $data['columns'],
            $data['dependencies']
        );

        $CsvToSqlImporter->convert();
    }

<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'urlManager' => [
                            'class' => 'yii\web\UrlManager',
                    // Disable index.php
                             'showScriptName' => false,
                    // Disable r= routes
                             'enablePrettyUrl' => true,
                            'rules' => array(
                                     '<controller:\w+>/<id:\d+>' => '<controller>/view',
                                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                                    ),
                       ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
        'authManager' => [
        'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
    ],
    'user' => [
        'class' => 'yii\web\User',
        'identityClass' => 'mdm\admin\models\User',
        'loginUrl' => ['admin/user/login'],
    ]
    ],
    
    'modules' => [
    'admin' => [
        'class' => 'mdm\admin\Module',
     ],       
    ]
];

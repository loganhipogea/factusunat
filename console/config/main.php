<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    
    
    
    
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    /*'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    
    ],*/
    
     'controllerMap' => [
         'migrate' => [
		'class' => 'yii\console\controllers\MigrateController',
		'migrationNamespaces' => [
			//'nemmo\attachments\migrations',
		],
         ],
        'migrate-build' => [
            'class' => 'yii\console\controllers\MigrateController',
             'migrationPath'=>[
                '@console/migrations/build',
                
                ],          
            //'migrationTable' => 'migration_rbac',
            //'migrationPath' => null,
        ],
         
     
         
        'migrate-core' => [
            'class' => 'yii\console\controllers\MigrateController',
             'migrationPath'=>[
                '@yii/rbac/migrations',
                '@mdm/admin/migrations',
                '@yii/log/migrations',
                '@vendor/yii2mod/yii2-settings/migrations/',
                '@vendor/nemmo/yii2-attachments/migrations',
                ],
            'migrationNamespaces' => ['nemmo\attachments\migrations'],
            'migrationTable' => 'migration_rbac',
            //'migrationPath' => null,
        ],
        
        'migrate-general' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => ['console\migrations'],
           // 'migrationTable' => 'migration_app',
            //'migrationPath' => null,
        ],
        
        // Migrations for the specific project's module
        'migrate-modules' => [
           'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                 /*'frontend\modules\clasi\database\migrations',
                'frontend\modules\sigi\database\migrations',
                'frontend\modules\cc\database\migrations',
                'frontend\modules\import\database\migrations',
                'frontend\modules\report\database\migrations',
                 'frontend\modules\mat\database\migrations',
                'frontend\modules\op\database\migrations',*/
                //'frontend\modules\regacad\database\migrations',
               // 'frontend\modules\repositorio\database\migrations',
                //'frontend\modules\acad\database\migrations',
               // 'backend\modules\base\database\migrations',
                
                ],
            'migrationTable' => 'migration_module',
            'migrationPath' => null,
        ],
        // Migrations for the specific extension
        
        
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];

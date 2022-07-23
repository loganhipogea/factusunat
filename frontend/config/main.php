<?php
 

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'language'=>'es',
    'sourceLanguage' => 'en',
     'timeZone' => 'America/Lima',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules'=>[
       
        'logi' => [
            'class' => 'frontend\modules\logi\Module',
                ],
         'com' => [
            'class' => 'frontend\modules\com\Module',
        ],
         'cc' => [
            'class' => 'frontend\modules\cc\Module',
        ],
        'op' => [
            'class' => 'frontend\modules\op\OpModule',
        ],
        'mat' => [
            'class' => 'frontend\modules\mat\Module',
        ],
    ],
    'components' => [
        
         'comboValores'=>[
            'class'=>'common\components\ComboCatalog',
        ],
        
        'view' => [
               'theme' => [
                        'pathMap' => [
                           // '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app',
                              //'@app/views' => '@app/views/skins/adminlte',
                                   
                                    //'@app/views' => '@app/views/skins/vertical',
                                    '@app/views' => '@app/views/skins/gentella',
                                    //'@app/views' => '@vendor/yiister/yii2-gentelella/views'
                                ],
                        ],
                    ],
        'request' => [
        'csrfParam' => '_csrf-frontend',
        //'baseUrl' => '/factusunat', //http://localhost/yii-advanced
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
         
        
    ],
   
    'params' => $params,
];

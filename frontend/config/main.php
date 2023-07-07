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
        
         'telegram' => [
        'class' => 'frontend\modules\telegram\Module',
        'API_KEY' => '5462135208:AAHH_8_h9eYDtdTfyso9mABVEO4fOL0YDOA',
        'BOT_NAME' => 'hornompf',
        'hook_url' => 'https://www.neotegnia.com/frontend/web/telegram/default/hook', // must be https! (if not prettyUrl https://yourhost.com/index.php?r=telegram/default/hook)
        'PASSPHRASE' => 'frase_para_login',
        // 'db' => 'db2', //db file name from config dir
        // 'userCommandsPath' => '@app/modules/telegram/UserCommands',
        // 'timeBeforeResetChatHandler' => 60
            ],
        
       
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
        'bigitems' => [
            'class' => 'frontend\modules\bigitems\Module',
        ],
    ],
    'components' => [       
        
    'telegram' => [
		
               'class' => 'common\tlbot\TelegramMinerva',
		'botToken' => '5462135208:AAHH_8_h9eYDtdTfyso9mABVEO4fOL0YDOA',
	],
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
         'mailer' =>['class'=>'common\components\Mailer',
                'viewPath'=>'@frontend/mail',
            ],
        
    ],
   'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [           
            'site/login/',
            'site/clear-cache/',
            'tlbot/nxguyu',
            'telegram/default/hook',
             'site/request-password-reset',
            'site/reset-password', 
           'site/logout',
           'site/mantenimiento',  
           'site/correolibre',  
            
        ]
    ],
    'params' => $params,
];

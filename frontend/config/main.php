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
    'components' => [
        'view' => [
                'theme' => [
                        'pathMap' => [
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
    'modules'=>[
        'attachments' => [
		'class' => nemmo\attachments\Module::className(),
		'tempPath' => '@app/uploads/temp',
		'storePath' => '@app/uploads/store',
		'rules' => [ // Rules according to the FileValidator
		    'maxFiles' => 10, // Allow to upload maximum 3 files, default to 3
			'mimeTypes' => 'image/png', // Only png images
			'maxSize' => 1024 * 1024 // 1 MB
		],
		'tableName' => '{{%attachments}}' // Optional, default to 'attach_file'
	],
    ],
    'params' => $params,
];

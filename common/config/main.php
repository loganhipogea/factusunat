<?php
return [
    'name'=>'NeoZolver ®',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'sunat'=>[
            'class'=>'common\components\SunatCatalog',
        ],
        
        'formatter' => [
            //'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'nullDisplay'=>''
           // 'currencyCode' => 'EUR',
       ],
        
        
        'moneda'=>['class' => 'common\components\Moneda',],
        'html2pdf' => [
            'class' => 'yii2tech\html2pdf\Manager',
            'viewPath' => '@app/views/pdf',
            'converter' => 'wkhtmltopdf',
            //'converter' => 'tcpdf',
        ],
          'log' => [
                //'traceLevel' => YII_DEBUG ? 3 : 0,            
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error'],
                ],
               /* [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'categories' => ['yii\db\*'],
                    'message' => [
                       'from' => ['log@example.com'],
                       'to' => ['admin@example.com', 'developer@example.com'],
                       'subject' => 'Database errors at example.com',
                    ],
                ],*/
            ],
        ],
        
          'i18n' => [
            'translations' => [ 
                 'import.errors' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/import/messages',
                                            ], 
                 'import.labels' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/import/messages',
                                            ], 
                'logi.labels' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/logi/messages',
                                            ], 
                        
                'rbac-admin'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@mdm/admin/messages',
                    'sourceLanguage' => 'en',
                ],
                
                'yii2mod.settings' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@yii2mod/settings/messages',
                                            ],  
                 'base.verbs'=>[
                            'class' => 'yii\i18n\PhpMessageSource',
                           'basePath' => '@messages',                                         
                     
                     
                     ], 
                
                        'base.names'=>[
                            'class' => 'yii\i18n\PhpMessageSource',
                           'basePath' => '@messages',                                         
                              ],
                      'base.errors'=>[
                            'class' => 'yii\i18n\PhpMessageSource',
                           'basePath' => '@messages',                                         
                              ],
                          'base.responses'=>[
                            'class' => 'yii\i18n\PhpMessageSource',
                           'basePath' => '@messages',                                         
                              ],
                  ],
              
                  
                  
              ],
        
        
        
        
  'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
               
           ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
        'authManager' => [
        'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
    ],
    /*'user' => [
        'class' => 'yii\web\User',
        'identityClass' => 'mdm\admin\models\User',
        'loginUrl' => ['admin/user/login'],
    ],*/
        'user' => [
         'class' => 'common\components\User',
        //'identityClass' => 'mdm\admin\models\User',
            'identityClass' => 'common\models\User',
        //'loginUrl' => ['admin/user/login'],
         'loginUrl' => ['site/login'],  
           'enableAutoLogin'=>false,
           // authTimeout
            'enableSession' => true,
            'authTimeout'=>60*60*2,
    ],
        
        'settings' => [
        'class' => 'yii2mod\settings\components\Settings',
    ],
    ],
    
    'modules' => [
        'gridview' =>  [
        'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
        ],
        'attachments' => [
		'class' => nemmo\attachments\Module::className(),
		'tempPath' => '@app/uploads/temp',
		'storePath' => '@app/uploads/store',
		'rules' => [ // Rules according to the FileValidator
		    'maxFiles' => 10, // Allow to upload maximum 3 files, default to 3
			//'mimeTypes' => 'image/png', // Only png images
			'maxSize' => 1024 * 1024 *30 // 1 MB
		],
		'tableName' => '{{%newattachments}}' // Optional, default to 'attach_file'
	],
        
    'admin' => [
        'class' => 'mdm\admin\Module',
     ], 
        
      'settings' => [
        'class' => 'yii2mod\settings\Module',
    ],
        
       'import' => [
                'class' => 'frontend\modules\import\ModuleImport',
            ],
        'sunat' => [
            'class' => 'frontend\modules\sunat\Module',
        ],
    ],
    
     
   
];




<?php
namespace frontend\assets\tabler;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAssetTabler extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
         'tabler/dist/css/tabler.min.css',
         //'tabler/dist/css/dashboard.css',
        // 'tabler/dist/css/tabler.css',
    ];
    public $js = [
        
    ];
    public $depends = [
         //'synamen\yii2tabler\assets\ThemeAsset',
    ];
}
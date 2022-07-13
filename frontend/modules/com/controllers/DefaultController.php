<?php

namespace frontend\modules\com\controllers;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `com` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
     public function actionConfig()
    {
        return $this->redirect(Url::toRoute(['/config/settings-module','module'=>\Yii::$app->controller->module->id]));
    }
}

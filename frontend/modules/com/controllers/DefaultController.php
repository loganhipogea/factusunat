<?php

namespace frontend\modules\com\controllers;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `com` module
 */
class DefaultController extends Controller
{
   public function actions() {
      parent::actions();
      return [           
          'config'=> [
                        'class' => 'common\actions\ActionConfigModule',
                       ],
            ];
      
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /* public function actionConfig()
    {
        return $this->redirect(Url::toRoute(['/config/settings-module','module'=>\Yii::$app->controller->module->id]));
    }*/
}

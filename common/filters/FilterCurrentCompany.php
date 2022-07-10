<?php
namespace common\filters;
use Yii;
use yii\base\ActionFilter;
use yii\helpers\Url;
use common\helpers\h;
use common\components\PerTest;
use common\models\masters\VwSociedades;
/*
/*
 * Este filtro se implementa para 

 */
class FilterCurrentCompany extends ActionFilter
{
    
    public function beforeAction($action)
    {
        VwSociedades::currentCompany();
        \yii::$app->session->set('mi-ex-url', Url::current());
       return parent::beforeAction($action); 
       
    }

    public function afterAction($action, $result)
    {
       
        return parent::afterAction($action, $result);
    }
}
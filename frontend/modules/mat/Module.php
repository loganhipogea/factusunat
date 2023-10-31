<?php

namespace frontend\modules\mat;
use common\helpers\h;
/**
 * mat module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\mat\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        h::getIfNotPutSetting('mat','reserva_automatica', 'YES');
         h::getIfNotPutSetting('mat','req_compra_automatica', 'YES');
        parent::init();

        // custom initialization code goes here
    }
    
    public static function isReservaAuto(){
        return h::gsetting('mat','reserva_automatica')=='YES';
    }
    
    public function isReqAutoCompras(){
       return h::gsetting('mat','req_compra_automatica')=='YES';  
    }
}

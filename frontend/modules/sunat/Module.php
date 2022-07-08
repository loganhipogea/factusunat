<?php

namespace frontend\modules\sunat;

/**
 * sunat module definition class
 */
class Module extends \yii\base\Module
{
   CONST NAME_BOLETA_ELECTRONICA='BOLETA ELECTRONICA';
  CONST NAME_FACTURA_ELECTRONICA='FACTURA ELECTRONICA';
    
    public $catalogs=[
        
    ];
    
    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\sunat\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    
    
    
    
}

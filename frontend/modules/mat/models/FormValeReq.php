<?php

namespace frontend\modules\mat\models;
use common\helpers\h;
use Yii;
use yii\base\Model;
use common\models\base\modelBase;

class FormValeReq extends modelBase
{
  
    public $numerodoc;
    public $codal;
    
    /**
     * {@inheritdoc}
     */
    
    
    public static function tableName(): string {
        
        return '{{%mat_req}}';
    }
    public function rules()
    {
        return [
            // username and password are both required
            [['numerodoc','codal'], 'required'],
            ['numerodoc', 'validateDocu'],
        ];
    }

    
     public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numerodoc' => Yii::t('base.names', 'Num requer'),
           
            'codal' => Yii::t('base.names', 'Almacenes'),
        ];
    }

    /**
      @param array $params the additional name-value pairs given in the rule
     */
    public function validateDocu($attribute, $params)
    {        
       if(is_null($model= MatReq::find()->andWhere(['numero'=>$this->numerodoc])->one()))
         $this->addError($attribute, yii::t('base.errors','Este número de solicitud no existe.'));
       
       if(count($model->idReservas(false,$this->codal))==0)
          $this->addError($attribute, yii::t('base.errors','Esta solicitud no tiene reservas pendientes'));
         
    }
    
    
    public function getRequerimiento(){
       
        return $this->hasOne(MatReq::className(), ['numero' => 'numerodoc']);
    
    }

}

<?php

namespace frontend\modules\com\models;
use common\models\masters\Centros;
use common\models\masters\Almacenes;
use frontend\modules\logi\models\LogiVwStock;
use Yii;

class ComOv extends \common\models\base\modelBase
{
    
    public $despro='';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_ov}}';
    }

    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rucodni', 'codcen'], 'required'],
            [['rucodni', 'numero'], 'string', 'max' => 14],
            [['codcen'], 'string', 'max' => 4],
            [['codsoc'], 'string', 'max' => 1],
            [['tipodoc', 'tipopago'], 'string', 'max' => 3],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'rucodni' => Yii::t('base.names', 'Rucodni'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'tipodoc' => Yii::t('base.names', 'Tipodoc'),
            'tipopago' => Yii::t('base.names', 'Tipopago'),
            'numero' => Yii::t('base.names', 'Numero'),
        ];
    }

    public function getClipro()
    {
        return $this->hasOne(Centros::className(), ['rucodni' => 'rucpro']);
    }
    
    public function getOv()
    {
        return $this->hasOne(ComOv::className(), ['id' => 'ov_id']);
    }
    
    

    public function getCentro()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    public function getComOvdets()
    {
        return $this->hasMany(ComOvdet::className(), ['ov_id' => 'id']);
    }

   
    public static function find()
    {
        return new ComOvQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if ($insert){
            $this->prefijo=$this->codcen;
            $this->numero=$this->correlativo('numero');
        }
        return parent::beforeSave($insert);
    }
}

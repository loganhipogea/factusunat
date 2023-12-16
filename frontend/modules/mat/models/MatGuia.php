<?php

namespace frontend\modules\mat\models;
USE common\models\masters\Centros;
use Yii;

/**
 * This is the model class for table "{{%mat_guia}}".
 *
 * @property int $id
 * @property string|null $codpro
 * @property string|null $codtra
 * @property string|null $fecha
 * @property string|null $fectra
 * @property string|null $numero
 * @property string|null $codcen
 * @property string|null $descripcion
 * @property string|null $placa
 * @property string|null $detalle
 */
class MatGuia extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_guia}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detalle'], 'string'],
             [['codcencli'], 'safe'],
            [['codpro', 'codtra', 'fecha', 'fectra'], 'string', 'max' => 10],
            [['numero'], 'string', 'max' => 14],
            [['codcen'], 'string', 'max' => 5],
            [['descripcion'], 'string', 'max' => 40],
            [['placa'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codpro' => Yii::t('app', 'Codpro'),
            'codtra' => Yii::t('app', 'Codtra'),
            'fecha' => Yii::t('app', 'Fecha'),
            'fectra' => Yii::t('app', 'Fectra'),
            'numero' => Yii::t('app', 'Numero'),
            'codcen' => Yii::t('app', 'Codcen'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'placa' => Yii::t('app', 'Placa'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatGuiaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatGuiaQuery(get_called_class());
    }


public function beforeSave($insert) {
        IF($insert){            
            $this->item= $this->nextItem();
                     if($this->hasChanged('codcencli')){
                                    $this->codpro= Centros::findOne($this->codcencli)->codpro;
                            }  
                  }         
        RETURN parent::beforeSave($insert);
    }
}
<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "trabajcuadrilla".
 *
 * @property int $id
 * @property int|null $cuadrilla_id
 * @property string|null $codcuadrilla_id
 * @property int|null $trabajador_id
 * @property string|null $codtra_id
 * @property string|null $textodetalle
 */
class Trabajcuadrilla extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trabajcuadrilla';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['codtra_id','turno_id'], 'required'],
            [['cuadrilla_id', 'trabajador_id'], 'integer'],
            [['textodetalle'], 'string'],
             [['codtra_id','cuadrilla_id'], 'unique',
                 'targetAttribute' => ['codtra_id','cuadrilla_id'],
                 'message'=>Yii::t('base.errors','Ya existe esta combinación de valores'),
                 ],
            [['codcuadrilla_id'], 'string', 'max' => 14],
            [['codtra_id'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cuadrilla_id' => Yii::t('app', 'Cuadrilla ID'),
            'codcuadrilla_id' => Yii::t('app', 'Codcuadrilla ID'),
            'trabajador_id' => Yii::t('app', 'Trabajador ID'),
            'codtra_id' => Yii::t('app', 'Codtra ID'),
            'textodetalle' => Yii::t('app', 'Textodetalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TrabajcuadrillaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrabajcuadrillaQuery(get_called_class());
    }
    
    
     public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra_id']);
    }
    
    public function getTurno()
    {
        return $this->hasOne(Turnos::className(), ['id' => 'turno_id']);
    }
    
    public function beforeSave($insert) {
        
         $this->trabajador_id=$this->trabajador->id;
        
        return parent::beforeSave($insert);
    }

}

<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%turnosasignaciones}}".
 *
 * @property int $id
 * @property int|null $trabajcuadrilla_id
 * @property int|null $codtra_id
 * @property string|null $codtra
 * @property string|null $descripcion
 * @property string|null $fecha
 * @property int|null $turno_id
 * @property string|null $activo
 */
class Turnosasignaciones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%turnosasignaciones}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trabajcuadrilla_id', 'codtra_id', 'turno_id'], 'integer'],
            [['trabajcuadrilla_id', 'turno_id'], 'unique',
                'targetAttribute'=>['trabajcuadrilla_id', 'turno_id'],
                'message'=>yii::t('base.errors','Esta combinacion de valores ya ha sido tomada'),
                ],
            [['codtra'], 'string', 'max' => 6],
            [['descripcion'], 'string', 'max' => 40],
            [['fecha'], 'string', 'max' => 10],
            [['activo'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'trabajcuadrilla_id' => Yii::t('app', 'Trabajcuadrilla ID'),
            'codtra_id' => Yii::t('app', 'Codtra ID'),
            'codtra' => Yii::t('app', 'Codtra'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'fecha' => Yii::t('app', 'Fecha'),
            'turno_id' => Yii::t('app', 'Turno ID'),
            'activo' => Yii::t('app', 'Activo'),
        ];
    }

     public function getPermisos(){
    
        return $this->hasMany(Turnoscambio::className(), ['turno_id' => 'id']);
   
    }
    
    
    /**
     * {@inheritdoc}
     * @return TurnosasignacionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TurnosasignacionesQuery(get_called_class());
    }
    
    public function hasPermisos(){
        return $this->getPermisos()->andWhere(['aprobado'=>'1'])->count()>0;
    }
    
    public function lastPermiso(){
         return $this->getPermisos()->andWhere(['aprobado'=>'1'])->orderBy(['fecha'=>SORT_DESC])->one();
    }
}

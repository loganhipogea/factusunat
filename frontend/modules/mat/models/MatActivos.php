<?php

namespace frontend\modules\mat\models;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%mat_activos}}".
 *
 * @property int $id
 * @property string|null $codigo
 * @property string|null $descripcion
 * @property string|null $marca
 * @property string|null $modelo
 * @property string|null $serie
 * @property float|null $v_adquisicion
 * @property int|null $vida_util
 * @property float|null $v_rescate
 * @property int|null $parent_id
 */
class MatActivos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public $prefijo='98';
    public static function tableName()
    {
        return '{{%mat_activos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['v_adquisicion', 'v_rescate'], 'number'],
            [['vida_util', 'parent_id'], 'integer'],
            [['codigo', 'descripcion', 'marca', 'modelo', 'serie'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Codigo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'marca' => Yii::t('app', 'Marca'),
            'modelo' => Yii::t('app', 'Modelo'),
            'serie' => Yii::t('app', 'Serie'),
            'v_adquisicion' => Yii::t('app', 'V Adquisicion'),
            'vida_util' => Yii::t('app', 'Vida Util'),
            'v_rescate' => Yii::t('app', 'V Rescate'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatActivosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatActivosQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->codigo=$this->correlativo('codigo');
        }
            
        return parent::beforeSave($insert);
    }
    
    
     public function getCostosHora()
    {
        return $this->hasMany(MatActivoscecos::className(), ['activo_id' => 'id']);
    }
    
    
    public function costoHora($codmon = \common\models\masters\Tipocambio::COD_MONEDA_BASE){
      $valor=  $this->getCostosHora()->select(['sum(valor)'])->scalar();
      if($valor > 0){
          return h::tipoCambio($codmon)['compra']*$valor;
      }else{
          return 0;
      }
          
    }
    
    
    
}

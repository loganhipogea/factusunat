<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "mat_activos".
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
 * @property string|null $codart
 * @property string|null $tipo
 * @property string|null $codsoc
 * @property string|null $codocu
 * @property string|null $codestado
 * @property string|null $modalidad
 */
class MatActivos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mat_activos';
    }

     public function behaviors()
         {
                return [
		
		'fileBehavior' => [
			'class' => '\common\behaviors\FileBehavior' 
                               ],
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['v_adquisicion', 'v_rescate'], 'number'],
            [['vida_util', 'parent_id'], 'integer'],
            [['codigo'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 60],
             [['texto_interno','texto_comercial','cod_altern'], 'safe'],
            [['marca', 'modelo', 'serie'], 'string', 'max' => 50],
            [['codart'], 'string', 'max' => 14],
            [['tipo', 'codsoc', 'modalidad'], 'string', 'max' => 1],
            [['codocu'], 'string', 'max' => 3],
            [['codestado'], 'string', 'max' => 2],
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
            'codart' => Yii::t('app', 'Codart'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codsoc' => Yii::t('app', 'Codsoc'),
            'codocu' => Yii::t('app', 'Codocu'),
            'codestado' => Yii::t('app', 'Codestado'),
            'modalidad' => Yii::t('app', 'Modalidad'),
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
    
    
     public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['codart' => 'codart']);
    }
    
    public function getPartes()
    {
        return $this->hasOne(MatDespiece::className(), ['activo_id' => 'id']);
    }
    
    public function hasPartes(){
        return $this->getPartes()->count() >0;
    }
    
    public function getChilds($as_array=true){
        
    }
}

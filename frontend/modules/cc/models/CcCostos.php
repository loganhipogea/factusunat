<?php

namespace frontend\modules\cc\models;
use common\models\base\modelBase;
use common\interfaces\CosteoInterface;
use Yii;

/**
 * This is the model class for table "{{%cc_costos}}".
 *
 * @property int $id
 * @property string|null $fecha
 * @property string|null $codocu
 * @property string|null $numdoc
 * @property int|null $iddocu
 * @property string|null $codocuref
 * @property string|null $numdocref
 * @property int|null $iddocuref
 * @property string|null $tipo
 * @property string|null $descripcion
 * @property string|null $codcen
 * @property float|null $monto
 * @property int|null $user_id
 */
class CcCostos extends modelBase 
{
    
    
    
   public $dateorTimeFields = [
        'fecha' => self::_FDATE,
        //'fechaini' => self::_FDATE,
        //'ftermino' => self::_FDATETIME
    ]; 
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cc_costos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iddocu', 'iddocuref', 'user_id'], 'integer'],
            [['monto'], 'number'],
            [['fecha'], 'string', 'max' => 10],
            [['codocu', 'numdoc', 'codocuref', 'numdocref', 'codcen'], 'string',],
            [['tipo'], 'string', 'max' => 1],
            [['descripcion'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'fecha' => Yii::t('base.names', 'Fecha'),
            'codocu' => Yii::t('base.names', 'Codocu'),
            'numdoc' => Yii::t('base.names', 'Numdoc'),
            'iddocu' => Yii::t('base.names', 'Iddocu'),
            'codocuref' => Yii::t('base.names', 'Codocuref'),
            'numdocref' => Yii::t('base.names', 'Numdocref'),
            'iddocuref' => Yii::t('base.names', 'Iddocuref'),
            'tipo' => Yii::t('base.names', 'Tipo'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'monto' => Yii::t('base.names', 'Monto'),
            'user_id' => Yii::t('base.names', 'User ID'),
        ];
    }

    
     public function getDocumento()
    {
        return $this->hasOne(\frontend\modules\bigitems\models\Documentos::className(), ['codocu' => 'codocu']);
    }
    
    
    
    /**
     * {@inheritdoc}
     * @return CcCostosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CcCostosQuery(get_called_class());
    }
    
    
    public static function createRegistro( 
            CosteoInterface $docGenerador,
            CosteoInterface $docReferencia){
       $model= self::instance();
       $model->setAttributes([
           'fecha'=>self::currentDateInFormat(),
           'codocu'=>$docGenerador->codocu(),
           'numdoc'=>$docGenerador->numerodoc(),
           'iddocu'=>$docGenerador->id,
           'tipo'=>$docGenerador->tipo(),
           'codcen'=>$docGenerador->codcen(),
           'monto'=>$docGenerador->monto(),
           'codocuref'=>$docReferencia->codocu(),
           'numdocref'=>$docReferencia->numerodoc(),
           'iddocuref'=>$docReferencia->id,
           
       ]);
       $exito=  $model->save();
       return ($exito)?[]:['error'=>$model->getFirstError()];
       
    }
    
    
    
}

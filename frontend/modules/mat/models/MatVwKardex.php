<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_vw_kardex}}".
 *
 * @property int $id
 * @property int|null $detreq_id
 * @property int $detvale_id
 * @property string|null $fecha
 * @property float|null $cant
 * @property string|null $um
 * @property int|null $stock_id
 * @property string|null $umreal
 * @property string|null $codmov
 * @property int|null $signo
 * @property string|null $codart
 * @property string|null $codal
 * @property string $descripcion
 * @property string $descritransa
 * @property string|null $codocu
 * @property string|null $numerodoc
 * @property string $codpro
 * @property string $despro
 * @property float|null $valor
 * @property float|null $punit
 * @property string $desdocu
 */
class MatVwKardex extends \common\models\base\modelBase
{
    
     public $fecha1; 
     
   public $dateorTimeFields = [ 
       'fecha' => self::_FDATE, 
        'fecha1' => self::_FDATE,  
          
   ]; 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_vw_kardex}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'detreq_id', 'detvale_id', 'stock_id', 'signo'], 'integer'],
            [['detvale_id', 'descripcion', 'descritransa', 'codpro', 'despro', 'desdocu'], 'required'],
            [['cant', 'valor', 'punit'], 'number'],
            [['fecha', 'codpro'], 'string', 'max' => 10],
            [['um', 'umreal', 'codal'], 'string', 'max' => 4],
            [['codmov', 'codocu'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion', 'despro', 'desdocu'], 'string', 'max' => 60],
            [['descritransa', 'numerodoc'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'detreq_id' => Yii::t('base.names', 'Detreq ID'),
            'detvale_id' => Yii::t('base.names', 'Detvale ID'),
            'fecha' => Yii::t('base.names', 'Fecha'),
            'cant' => Yii::t('base.names', 'Cant'),
            'um' => Yii::t('base.names', 'Um'),
            'stock_id' => Yii::t('base.names', 'Stock ID'),
            'umreal' => Yii::t('base.names', 'Um'),
            'codmov' => Yii::t('base.names', 'Mov'),
            'signo' => Yii::t('base.names', 'Signo'),
            'codart' => Yii::t('base.names', 'Código'),
            'codal' => Yii::t('base.names', 'Codal'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'descritransa' => Yii::t('base.names', 'Mov.'),
            'codocu' => Yii::t('base.names', 'Doc'),
            'numerodoc' => Yii::t('base.names', 'Número'),
            'codpro' => Yii::t('base.names', 'Proveed'),
            'despro' => Yii::t('base.names', 'Proveed'),
            'valor' => Yii::t('base.names', 'Valor'),
            'punit' => Yii::t('base.names', 'Punit'),
            'desdocu' => Yii::t('base.names', 'Doc'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatVwKardexQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatVwKardexQuery(get_called_class());
    }
}

<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_vw_ingresos}}".
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
 * @property string|null $item
 * @property float $cant
 * @property string|null $codum
 * @property string|null $codart
 * @property string|null $descri
 * @property string|null $codaf
 * @property string|null $serie
 */
class MatVwIngresos extends \common\models\base\modelBase
{
    
     public $fecha1; 
     
   public $dateorTimeFields = [ 
       'fecha' => self::_FDATE, 
        'fecha1' => self::_FDATE,  
          
   ]; 
     //public $booleanFields=['rotativo','activo'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_vw_ingresos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['detalle'], 'string'],
            [['descri'], 'safe'],
            [['cant'], 'number'],
            [['codpro', 'codtra', 'fecha', 'fectra'], 'string', 'max' => 10],
            [['numero', 'codart', 'codaf'], 'string', 'max' => 14],
            [['codcen'], 'string', 'max' => 5],
            [['descripcion', 'descri'], 'string', 'max' => 40],
            [['placa', 'serie'], 'string', 'max' => 20],
            [['item'], 'string', 'max' => 3],
            [['codum'], 'string', 'max' => 4],
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
            'codcen' => Yii::t('app', 'Local'),
             'codcencli' => Yii::t('app', 'Sede origen'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'placa' => Yii::t('app', 'Placa'),
            'detalle' => Yii::t('app', 'Detalle'),
            'item' => Yii::t('app', 'Item'),
            'cant' => Yii::t('app', 'Cant'),
            'codum' => Yii::t('app', 'Codum'),
            'codart' => Yii::t('app', 'Codart'),
            'descri' => Yii::t('app', 'Descri'),
            'codaf' => Yii::t('app', 'Codaf'),
            'serie' => Yii::t('app', 'Serie'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatVwIngresosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatVwIngresosQuery(get_called_class());
    }
    
     public function getDetalleItem()
    {
        return $this->hasOne(MatDetNe::className(), ['id' => 'iddetalle']);
    }
}

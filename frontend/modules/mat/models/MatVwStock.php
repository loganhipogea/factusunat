<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_vw_stock}}".
 *
 * @property int $id
 * @property string $codart
 * @property float|null $cant
 * @property string|null $um
 * @property string|null $ubicacion
 * @property float|null $cantres
 * @property string|null $codal
 * @property float|null $valor
 * @property string|null $lastmov
 * @property float|null $valor_unit
 * @property float|null $cant_disp
 * @property string|null $semaforo
 * @property string $descripcion
 */
class MatVwStock extends \common\models\base\modelBase
{
   
    const SEMAFORO_EXCESO='E'; //Exceso de stock
    const SEMAFORO_OK='G';
    const SEMAFORO_CUIDADO='Y';
    const SEMAFORO_PELIGRO='R';//Ruptura de stock
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_vw_stock}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codart', 'descripcion'], 'required'],
            [['cant', 'cantres', 'valor', 'valor_unit', 'cant_disp'], 'number'],
            [['codart', 'ubicacion'], 'string', 'max' => 14],
            [['um', 'codal'], 'string', 'max' => 4],
            [['lastmov'], 'string', 'max' => 10],
            [['semaforo'], 'string', 'max' => 1],
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
            'codart' => Yii::t('base.names', 'Codart'),
            'cant' => Yii::t('base.names', 'Cant'),
            'um' => Yii::t('base.names', 'Um'),
            'ubicacion' => Yii::t('base.names', 'Ubicacion'),
            'cantres' => Yii::t('base.names', 'Cantres'),
            'codal' => Yii::t('base.names', 'Codal'),
            'valor' => Yii::t('base.names', 'Valor'),
            'lastmov' => Yii::t('base.names', 'Lastmov'),
            'valor_unit' => Yii::t('base.names', 'Valor Unit'),
            'cant_disp' => Yii::t('base.names', 'Cant Disp'),
            'semaforo' => Yii::t('base.names', 'Semaforo'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatVwStockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatVwStockQuery(get_called_class());
    }
    
     public function colorSemaforo(){
       switch ($this->semaforo) {
    case self::SEMAFORO_OK:
        return '#67E41E';
        break;
    case self::SEMAFORO_PELIGRO:
        return '#5BCF40';
        break;
     case self::SEMAFORO_CUIDADO:
        return '#FDD523';
        break;
    case self::SEMAFORO_EXCESO:
        return '#FC11A3';
        BREAK;
    }
    }
    
  public static function listaSemaforo(){
       return [
        self::SEMAFORO_EXCESO=>yii::t('base.names','SobreStock'), 
        self::SEMAFORO_OK=>yii::t('base.names','Regular'),
          self::SEMAFORO_PELIGRO=>yii::t('base.names','Ruptura'),  
           self::SEMAFORO_CUIDADO=>yii::t('base.names','Bajo stock'), 
       ];
   }
}

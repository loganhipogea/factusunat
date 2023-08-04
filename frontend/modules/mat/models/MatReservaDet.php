<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_reservadet}}".
 *
 * @property int $id
 * @property int|null $reserva_id
 * @property int|null $stock_id
 * @property string|null $item
 * @property string|null $fecha
 * @property float|null $cant
 * @property string|null $codestado
 * @property string|null $detalle
 */
class MatReservaDet extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public const ES_CREADO='A';
    public const ES_APROBADO='B';
    public const ES_RESERVADO='C';
    public const ES_ATENDIDO_PARCIAL='D';
    public const ES_ATENDIDO='E';
    public const ES_ANULADO='X'; //En este estado el campo  'activo' debe de ser obligaoriamente false
    
    public  $booleanFields=['activo'];
    public $dateorTimeFields = [
        'fecha' => self::_FDATETIME,  
          
    ];
    
    public static function tableName()
    {
        return '{{%mat_reservadet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reserva_id', 'stock_id'], 'integer'],
            [['cant'], 'number'],
            [['activo','detreq_id'], 'safe'],
            
            [['item'], 'string', 'max' => 4],
            [['fecha'], 'string', 'max' => 19],
            [['codestado'], 'string', 'max' => 1],
            [['detalle'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'reserva_id' => Yii::t('base.names', 'Reserva ID'),
            'stock_id' => Yii::t('base.names', 'Stock ID'),
            'item' => Yii::t('base.names', 'Item'),
            'fecha' => Yii::t('base.names', 'Fecha'),
            'cant' => Yii::t('base.names', 'Cant'),
            'codestado' => Yii::t('base.names', 'Codestado'),
            'detalle' => Yii::t('base.names', 'Detalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatReservaDetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatReservaDetQuery(get_called_class());
    }
    
    
    public function setAprobado(){
        $this->codestado=self::ES_APROBADO;
        return $this;
    }
    
    public function setAnulado(){
        $this->codestado=self::ES_ANULADO;
        
        return $this;
    }
    
    public function setAtendido(){
        $this->codestado=self::ES_ATENDIDO;
        return $this;
    }
    
    public function setAtendidoParcial(){
        $this->codestado=self::ES_ATENDIDO_PARCIAL;
        return $this;
    }
    
    public function setReservado(){
        $this->codestado=self::ES_RESERVADO;
        return $this;
    }    
    
    public function setInactivo(){
        $this->activo=false;
        return $this; 
    }
    
    
    
}

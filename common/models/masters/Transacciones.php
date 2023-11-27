<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "transacciones".
 *
 * @property string $codtrans
 * @property string $descripcion
 * @property int $signo
 * @property string|null $detalles
 *
 * @property Transadocs[] $transadocs
 */




class Transacciones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%transacciones}}';
    }
   public $booleanFields=[
       'exigirvalidacion',/*True Si exige validar el  
        * numero documento refereciaque respalda 
        * la transaccion, por ejemplo: Si se coloca un
        * numero de guia rem, este numero debe de
        * existir como registro MOdelo en la base de datos
        * del sistema
        * 
        */
       'afecta_precio',//Si el movimiento afectara la valorizacion del inventario
       'afecta_reserva',/*Si el movimiento implica modificar cantidades
        * reservadas
        * por ejemplo una salida para atender un requeremiento
        * debe de jalar de una reserva
        * debe de 
        */
       'es_servicio',//Para servicios
       'compromete_proveedor',/*Si el movimiento compromete a un proveedor
        * pore ejemplo ingreso por compra o consignacion
        */
       'exigehistorial'/*
        * Si el movimiento exige un registro de stock 
        * osea debe de haber un registro de stock para este
        * material,por ejemplo cuando sacas 
        * un material 
        */
       ];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtrans', 'descripcion', 'signo'], 'required'],
            [['signo'], 'integer'],
            [['detalles'], 'string'],
            [['exigirvalidacion','afecta_reserva','es_servicio','exigehistorial','afecta_precio','inversa_id','compromete_proveedor'], 'safe'],
            [ ['codtrans'],
                'match', 
                'pattern' => '/[1-9]{1}[0-9]{2}/',
                'message'=>yii::t('base.errors','Alphanumerics are not allowed and must not start with zero'),
                ],
            [['codtrans'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['codtrans'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codtrans' => Yii::t('base.names', 'Codtrans'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'signo' => Yii::t('base.names', 'Signo'),
            'detalles' => Yii::t('base.names', 'Detalles'),
        ];
    }

    /**
     * Gets query for [[Transadocs]].
     *
     * @return \yii\db\ActiveQuery|TransadocsQuery
     */
    public function getTransadocs()
    {
        return $this->hasMany(Transadocs::className(), ['codtrans' => 'codtrans']);
    }
    
     public function getInversa()
    {
        return $this->hasOne(Transacciones::className(), ['codtrans' => 'inversa_id']);
    }

    /**
     * {@inheritdoc}
     * @return TransaccionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransaccionesQuery(get_called_class());
    }
}

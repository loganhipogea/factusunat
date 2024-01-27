<?php

namespace frontend\modules\mat\models;
use common\models\masters\Clipro;
use Yii;

/**
 * This is the model class for table "{{%mat_guia}}".
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
 */
class MatNe extends \common\models\base\modelBase
{
    
    
     const ESTADO_CREADO='10';
     const ESTADO_APROBADO='20';
     //const ESTADO_CERRADO='30';
      const ESTADO_ANULADO='99';
    public $prefijo='62';
    public $fecha1;
    public $fechacon1;
    public $dateorTimeFields = [
        'fecha' => self::_FDATE, 
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_guia}}';
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
            [['detalle'], 'string'],
            [['codcen','codcencli','fecha'], 'required'],
            [['codocuref','numdocref'], 'safe'],
            [['codpro', 'codtra', 'fecha', 'fectra'], 'string', 'max' => 10],
            [['numero'], 'string', 'max' => 14],
            [['codcen'], 'string', 'max' => 5],
            [['descripcion'], 'string', 'max' => 40],
            [['placa'], 'string', 'max' => 20],
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
            'codcencli' => Yii::t('app', 'Lugar origen'),
            'codcen' => Yii::t('app', 'Lugar recepción'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'placa' => Yii::t('app', 'Placa'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatGuiaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatNeQuery(get_called_class());
    }
    
     public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    
     public function getDocumentoRef()
    {
        return $this->hasOne(\common\models\masters\Documentos::className(), ['codocu' => 'codocuref']);
    }
    
    public function getCentroOrigen()
    {
        return $this->hasOne(\common\models\masters\Centros::className(), ['codcen' => 'codcencli']);
    }
    
     public function getCentroDestino()
    {
        return $this->hasOne(\common\models\masters\Centros::className(), ['codcen' => 'codcen']);
    }
    
     public function getDetalles()
    {
        return $this->hasMany(MatDetNe::className(), ['guia_id' => 'id']);
           //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }
     public function beforeSave($insert) {
        if($insert){
            $this->numero=$this->correlativo('numero',8);
           // $this->codest=self::ESTADO_CREADO;
        } 
        RETURN parent::beforeSave($insert);
    }
    
    
    public function validate_centros($attribute,$params){
        if($this->codcencli ==$this->codcen)
         $this->addError ('codcen',yii::t('base.errors','El destino no puede ser igual al origen'));
    }
}

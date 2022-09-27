<?php

namespace frontend\modules\mat\models;
use common\models\masters\Centros;
use common\models\masters\Clipro;
use common\models\masters\Trabajadores;
use Yii;

/**
 * This is the model class for table "mat_petoferta".
 *
 * @property int $id
 * @property string|null $numero
 * @property string|null $codcen
 * @property string|null $codsoc
 * @property string|null $fecha
 * @property string|null $codtra
 * @property int|null $user_id
 * @property string|null $estado
 * @property string|null $descripcion
 * @property string|null $detalle
 *
 * @property Centro $codcen0
 * @property MatDetpetofertum[] $matDetpetoferta
 */
class MatPetoferta extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mat_petoferta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['codtra','codpro','descripcion',
                 'fecha','codmon'], 'required'],
            [['user_id'], 'integer'],
             [['codpro'], 'string', 'max' => 10],
           
             [['codpro','codmon'], 'safe'],
            [['detalle'], 'string'],
            [['numero', 'fecha'], 'string', 'max' => 10],
            [['codcen'], 'string', 'max' => 5],
            [['codsoc'], 'string', 'max' => 1],
            [['codtra'], 'string', 'max' => 6],
            [['estado'], 'string', 'max' => 2],
            [['descripcion'], 'string', 'max' => 40],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero' => Yii::t('app', 'Numero'),
            'codcen' => Yii::t('app', 'Codcen'),
            'codsoc' => Yii::t('app', 'Codsoc'),
            'fecha' => Yii::t('app', 'Fecha'),
            'codtra' => Yii::t('app', 'Codtra'),
            'user_id' => Yii::t('app', 'User ID'),
            'estado' => Yii::t('app', 'Estado'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|CentroQuery
     */
    public function getCentro()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }
     public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

     public function getProveedor()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    /**
     * Gets query for [[MatDetpetoferta]].
     *
     * @return \yii\db\ActiveQuery|MatDetpetofertumQuery
     */
    public function getMatDetpetoferta()
    {
        return $this->hasMany(MatDetpetoferta::className(), ['petoferta_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MatPetofertaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatPetofertaQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->setCorrelativo('numero');
        }
        return parent::beforeSave($insert);
    }
}

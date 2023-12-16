<?php

namespace common\models\masters;
use common\helpers\h;
use Yii;

class MaestroMateriales extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maestrocompo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codart'], 'required'],
            [['sustancia_id', 'fasubsub_id'], 'integer'],
            [['codart', 'codean'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 80],
            [['marca', 'modelo', 'numeroparte'], 'string', 'max' => 30],
            [['codum', 'peso'], 'string', 'max' => 4],
            [['codtipo', 'codfam'], 'string', 'max' => 3],
            [['esrotativo'], 'string', 'max' => 1],
            [['codosce'], 'string', 'max' => 18],
            [['cod1', 'cod2'], 'string', 'max' => 10],
            [['codunsc', 'resolucion', 'regsan'], 'string', 'max' => 16],
            [['codsubfam', 'codsubsubfam'], 'string', 'max' => 2],
            [['codart'], 'unique'],
            [['codum'], 'exist', 'skipOnError' => true, 'targetClass' => Ums::class, 'targetAttribute' => ['codum' => 'codum']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codart' => 'Codart',
            'descripcion' => 'Descripcion',
            'marca' => 'Marca',
            'modelo' => 'Modelo',
            'numeroparte' => 'Numeroparte',
            'codum' => 'Codum',
            'peso' => 'Peso',
            'codtipo' => 'Codtipo',
            'esrotativo' => 'Esrotativo',
            'codean' => 'Codean',
            'codosce' => 'Codosce',
            'cod1' => 'Cod1',
            'cod2' => 'Cod2',
            'codunsc' => 'Codunsc',
            'resolucion' => 'Resolucion',
            'regsan' => 'Regsan',
            'sustancia_id' => 'Sustancia ID',
            'codfam' => 'Codfam',
            'codsubfam' => 'Codsubfam',
            'codsubsubfam' => 'Codsubsubfam',
            'fasubsub_id' => 'Fasubsub ID',
        ];
    }

    /**
     * Gets query for [[Codum0]].
     *
     * @return \yii\db\ActiveQuery|UmsQuery
     */
    public function getCodum0()
    {
        return $this->hasOne(Ums::class, ['codum' => 'codum']);
    }

    /**
     * Gets query for [[ComFactudets]].
     *
     * @return \yii\db\ActiveQuery|ComFactudetQuery
     */
    public function getComFactudets()
    {
        return $this->hasMany(ComFactudet::class, ['codart' => 'codart']);
    }

    /**
     * Gets query for [[ComOvdets]].
     *
     * @return \yii\db\ActiveQuery|ComOvdetQuery
     */
    public function getComOvdets()
    {
        return $this->hasMany(ComOvdet::class, ['codart' => 'codart']);
    }

    /**
     * Gets query for [[Conversiones]].
     *
     * @return \yii\db\ActiveQuery|ConversionesQuery
     */
    public function getConversiones()
    {
        return $this->hasMany(Conversiones::class, ['codart' => 'codart']);
    }

    /**
     * Gets query for [[Maestroclipros]].
     *
     * @return \yii\db\ActiveQuery|MaestrocliproQuery
     */
    public function getMaestroclipros()
    {
        return $this->hasMany(Maestroclipro::class, ['codart' => 'codart']);
    }

    /**
     * Gets query for [[MatClasificacions]].
     *
     * @return \yii\db\ActiveQuery|MatClasificacionQuery
     */
    public function getMatClasificacions()
    {
        return $this->hasMany(MatClasificacion::class, ['codart' => 'codart']);
    }

    /**
     * Gets query for [[MatDetreqs]].
     *
     * @return \yii\db\ActiveQuery|MatDetreqQuery
     */
    public function getMatDetreqs()
    {
        return $this->hasMany(MatDetreq::class, ['codart' => 'codart']);
    }

    /**
     * Gets query for [[MatDetvales]].
     *
     * @return \yii\db\ActiveQuery|MatDetvaleQuery
     */
    public function getMatDetvales()
    {
        return $this->hasMany(MatDetvale::class, ['codart' => 'codart']);
    }

    /**
     * Gets query for [[MatStock]].
     *
     * @return \yii\db\ActiveQuery|MatStockQuery
     */
    public function getMatStock()
    {
        return $this->hasOne(MatStock::class, ['codart' => 'codart']);
    }

    /**
     * Gets query for [[Stocks]].
     *
     * @return \yii\db\ActiveQuery|StockQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::class, ['codart' => 'codart']);
    }

    /**
     * {@inheritdoc}
     * @return MaestroMaterialesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MaestroMaterialesQuery(get_called_class());
    }
    
    
    private function generateCodDummy(){
      return 'TMP'. substr(microtime(),0,h::getIfNotPutSetting('general', 'ndigitos_maestro')-3);
    }
    
    
    public function beforeSave($insert) {
        //var_dump($insert);die();
        
        if($insert){            
            $this->codart=$this->generateCodDummy();            
        }
        return parent::beforeSave($insert);
    }
}

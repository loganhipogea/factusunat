<?php
namespace frontend\modules\mat\models;
use common\helpers\h;
use common\models\masters\Tipocambio;
use Yii;
class MatVwPetoferta extends \common\models\base\modelBase
{
    const VALOR_PROMEDIO='P';
    const VALOR_ULTIMO='U';
    const VALOR_ANTIGUO='A';
    
    public $fecha1=null;
    public $pventa1=null;
     public $dateorTimeFields=[
     'fecha'=>self::_FDATE,
     'fecha1'=>self::_FDATE,         
         ];
    public static function tableName()
    {
        return 'mat_vw_petoferta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'iddetalle'], 'integer'],
            [['cant', 'punit', 'igvdet', 'ptotal', 'pventa'], 'number'],
            [['despro'], 'required'],
            [['numero', 'fecha'], 'string', 'max' => 10],
            [['codmon', 'item', 'tipo'], 'string', 'max' => 3],
            [['igv'], 'string', 'max' => 1],
            [['codart'], 'string', 'max' => 14],
            [['codum'], 'string', 'max' => 4],
            [['descripcion', 'despro'], 'string', 'max' => 60],
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
            'fecha' => Yii::t('app', 'Fecha'),
            'codmon' => Yii::t('app', 'Codmon'),
            'igv' => Yii::t('app', 'Igv'),
            'iddetalle' => Yii::t('app', 'Iddetalle'),
            'item' => Yii::t('app', 'Item'),
            'codart' => Yii::t('app', 'Codart'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codum' => Yii::t('app', 'Codum'),
            'cant' => Yii::t('app', 'Cant'),
            'punit' => Yii::t('app', 'Punit'),
            'igvdet' => Yii::t('app', 'Igvdet'),
            'ptotal' => Yii::t('app', 'Ptotal'),
            'pventa' => Yii::t('app', 'Pventa'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'despro' => Yii::t('app', 'Despro'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatVwPetofertaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatVwPetofertaQuery(get_called_class());
    }
    
    public static function valor($codart,$codmon= Tipocambio::COD_MONEDA_BASE,$orden=self::VALOR_ULTIMO){
       $valor=  self::find()->select(['punit'])->andWhere(
                [
                    'codart'=>$codart,
                    
                ])
               ->andWhere(
                [
                    '>','pventa',0
                    
                ])
               ->orderBy(['fecha'=>SORT_DESC])->scalar();
      yii::error(self::find()->select(['punit'])->andWhere(
                [
                    'codart'=>$codart,
                    
                ]) ->andWhere(
                [
                    '>','pventa',0
                    
                ])->orderBy(['fecha'=>SORT_DESC])->createCommand()->rawSql,__FUNCTION__);
      if($valor >0) {
       $valor=h::tipoCambio($codmon)['compra']*$valor;  
      }else{
          $valor=0;
      }
      return $valor; 
    }
    
   
}

<?php

namespace common\models\masters;
use common\interfaces\ApiSunatInterface;
USE common\components\MyClientGeneral;

use Yii;

/**
 * This is the model class for table "{{%tipocambio}}".
 *
 * @property int $id
 * @property string $fecha
 * @property string $codmon
 * @property float $compra
 * @property float $venta
 * @property string|null $ultima
 */
class Tipocambio extends \common\models\base\modelBase
{        
    /**
     * {@inheritdoc}
     */
    private $_client=null;
    Const COD_MONEDA_DOLAR='USD';
   Const COD_MONEDA_BASE='PEN';
    public $dateOrTimeFields=[
        'fecha'=>self::_FDATE,
        'ultima'=>self::_FDATETIME
       ];
    public static function tableName()
    {
        return '{{%tipocambio}}';
    }
    
    public function getClient(){
        
        return $this->_client;
    }
    
    public function setClient(ApiSunatInterface $client){        
        $this->_client=$client;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'codmon', 'compra', 'venta'], 'required'],
            [['compra', 'venta'], 'number'],
            [['fecha'], 'string', 'max' => 10],
            [['codmon'], 'string', 'max' => 4],
            [['ultima'], 'string', 'max' => 19],
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
            'codmon' => Yii::t('base.names', 'Codmon'),
            'compra' => Yii::t('base.names', 'Compra'),
            'venta' => Yii::t('base.names', 'Venta'),
            'ultima' => Yii::t('base.names', 'Ultima'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TipocambioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TipocambioQuery(get_called_class());
    }
    
    public static function lastChangeTime($codmon){
        $last=self::find()->select(['ultima'])
         ->andWhere(['codmon'=>$codmon])->
           orderBy(['id'=>SORT_DESC])->one();
       if(is_null($last))return false;
    return false;
        
    }
    
    private static function whereBase($codmon,$fecha){
       return ['codmon'=>$codmon,'fecha'=>$fecha];
        
    }
    
    public static function getChange($codmon,$fecha){
        return self::find()->andWhere(self::whereBase($codmon, $fecha))->one();
    }
    
    public static function getSell($codmon,$fecha){
        $model= self::getChange($codmon, $fecha);
        if(!is_null($model))return $model->venta;
        return $model;
    }
    public static function getBuy($codmon,$fecha){
        $model= self::getChange($codmon, $fecha);
        if(!is_null($model))return $model->compra;
        return $model;
    }
        
    public function getChangeFromApi($codmon=self::COD_MONEDA_DOLAR,$fecha=null){
        $this->setClient(New MyClientGeneral());
        $respuesta=$this->client->apiTipoCambio($fecha);
        yii::error('repuesta del api :');
        yii::error($respuesta);
        if($respuesta){
            $datos=$respuesta;
            $datos['codmon']=$codmon;
            $registroA=$this->mapFieldsApi($datos);
            $this->storeFromApi($registroA);
            return $registroA;
            //$this->storeToCache($registroA);
        }else{
          return [];  
        }
        
    }
 
   private function storeFromApi($data){
       //$matriz=$this->mapFieldsApi($data);
        ///Intrentamos insetar el registro
            $res=self::firstOrCreateStatic($data,
                                    null,
                                    $this->whereBase($data['codmon'],$data['fecha'])
                                    );
         //Si no es el primero lo actualizamos 
            if(!$res)$this->updateAll (
                    $data,
                    $this->whereBase($data['codmon'],$data['fecha']));
            return $data;
   } 
    
  private function mapFieldsApi($resultado){
            $matriz=$resultado;
           
            //var_dump();die();
            //$matriz['fecha']=$fecha;
            //$matriz['codmon']=$matriz['codmon'];
            
            $matriz['ultima']=date('Y-m-d h:i:s');
            unset($matriz['origen']);
            unset($matriz['moneda']);
            return $matriz;
  } 
  
  public function beforeSave($insert) {
      
      return parent::beforeSave($insert);
  }
    
}

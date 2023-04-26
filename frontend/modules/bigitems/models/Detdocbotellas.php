<?php

namespace frontend\modules\bigitems\models;
 use frontend\modules\bigitems\interfaces\Transport;
use common\models\base\modelBase;
use Yii;

/**
 * This is the model class for table "{{%bigitems_detdocbotellas}}".
 *
 * @property int $id
 * @property int $doc_id
 * @property string $codigo
 * @property double $tarifa
 * @property string $codocuref
 * @property string $numdocuref
 * @property string $detalle
 * @property string $codestado
 *
 * @property Activos $codigo0
 * @property BigitemsDocbotellas $doc
 */
class Detdocbotellas extends modelBase implements Transport 
{
    const SCENARIO_CREACION_TABULAR='creaciontabular';
    const SCENARIO_UPDATE_TABULAR='updatetabular';
    public $descripcion; //campo ficticio para simular la descriciond ela botella 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bigitems_detdocbotellas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_id', 'codigo','coditem'], 'required'],
            [['doc_id'], 'integer'],
            [['tarifa'], 'number'],
            [['detalle'], 'string'],
            [['codigo', 'numdocuref'], 'string', 'max' => 16],
            [['codocuref'], 'string', 'max' => 3],
            [['codestado'], 'string', 'max' => 2],
            //[['codigo'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\masters\Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codigo'],'message'=>'WEste codigo no existe '],
           // [['doc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Docbotellas::className(), 'targetAttribute' => ['doc_id' => 'id']],
        ];
    }

     public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREACION_TABULAR] = ['codigo','coditem','tarifa'];
        $scenarios[self::SCENARIO_UPDATE_TABULAR] = ['codigo','coditem','tarifa'];
       // $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'doc_id' => Yii::t('base.names', 'Doc ID'),
            'codigo' => Yii::t('base.names', 'Codigo'),
            'tarifa' => Yii::t('base.names', 'Tarifa'),
            'codocuref' => Yii::t('base.names', 'Codocuref'),
            'numdocuref' => Yii::t('base.names', 'Numdocuref'),
            'detalle' => Yii::t('base.names', 'Detalle'),
            'codestado' => Yii::t('base.names', 'Codestado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['codart' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocbotella()
    {
        return $this->hasOne(Docbotellas::className(), ['id' => 'doc_id']);
    }

    /**
     * {@inheritdoc}
     * @return DetdocbotellasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DetdocbotellasQuery(get_called_class());
    }
    
     public function   moveAsset($codocu, $numdoc, $fecha, $nuevolugar){
         $result=false;
        if(!$this->isNewRecord){
            $documento=$this->docbotella;
            $result=$this->activo->moveAsset($documento->codocu,
                    $documento->numero,
                    $documento->fechatra,
                    $documento->ptoLlegadaOrAddress()
                    );
            unset($documento);
        }
        return $result;
       }
     public function   revertMoveAsset(){
         if($this->canRevertMoveAsset() && !$this->isNewRecord ){
           return $this->activo->revertMoveAsset();
        }else{
            return false;
        }
         
       }
    public function   canMoveAsset(){
         //reglas para saber si s epude mover 
        /*
         * 1) Tiene que estar en el punto de partida que consigana el documento
         */
        return true;
       }
   
     public function   canRevertMoveAsset(){
         //reglas para saber si s epude mover 
        /*
         * 1) Tiene que estar en el punto de partida que consigana el documento
         */
        return true;
       }  
      /*Coloca el flag de Transporte en el activo asociado*/ 
    public function setAssetOnTransport($on=true){
        if($this->canMoveAsset() && !$this->isNewRecord ){
           if($on){
             return $this->activo->changeOnTransport(true);  
           }else{
              return $this->activo->changeOffTransport(true);    
           }
           
        }else{
            return false;
        }
    }
    
    /*verifiac si se puede borrar este registro*/
  public function canDelete(){
      $condition=true; //COLOCAR AQUI NLA LGOICA 
    return ($this->hasChilds() && $condition);
  }
  
  
   /*verifiac si se puede anular este registro*/
  public function canTrash(){
      $condition=true; //COLOCAR AQUI NLA LGOICA 
      return $condition;
  }
}

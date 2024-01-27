<?php

namespace frontend\modules\prd\models;

use Yii;
use common\models\masters\Maestrocompo;
/**
 * This is the model class for table "mat_detreq".
 *
 * @property int $id
 * @property int|null $req_id
 * @property string|null $item
 * @property string|null $codart
 * @property string|null $descripcion
 * @property float|null $cant
 * @property string|null $um
 * @property string|null $imptacion
 * @property string|null $tipim
 * @property string|null $texto
 * @property string|null $activo
 * @property int|null $proc_id
 * @property int|null $os_id
 * @property int|null $detos_id
 * @property int|null $ultimo
 * @property int|null $user_id
 * @property string|null $fechaprog
 * @property string|null $tipo
 * @property int|null $codal
 * @property string|null $codpro
 * @property int|null $servicio_id
 * @property string|null $codest
 * @property int|null $ceco_id
 * @property int|null $detreq_id
 * @property int|null $detres_id
 * @property string|null $ruta
 * @property int|null $parent_id
 * @property string|null $clave
 * @property int|null $op_id
 *
 * @property Maestrocompo $codart0
 * @property MatAtenciones[] $matAtenciones
 * @property MatDetoc[] $matDetocs
 * @property MatReq $req
 */
class PrdOpDespiece extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mat_detreq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['req_id', 'proc_id', 'os_id', 'detos_id', 'ultimo', 'user_id', 'codal', 'servicio_id', 'ceco_id', 'detreq_id', 'detres_id', 'parent_id', 'op_id'], 'integer'],
            [['cant'], 'number'],
            [['texto', 'ruta'], 'string'],
            [['item', 'um'], 'string', 'max' => 4],
            [['codart', 'imptacion'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 40],
            [['tipim', 'activo'], 'string', 'max' => 1],
            [['fechaprog', 'codpro'], 'string', 'max' => 10],
            [['tipo'], 'string', 'max' => 3],
            [['codest'], 'string', 'max' => 2],
            [['clave'], 'string', 'max' => 20],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::class, 'targetAttribute' => ['codart' => 'codart']],
            [['req_id'], 'exist', 'skipOnError' => true, 'targetClass' => MatReq::class, 'targetAttribute' => ['req_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'req_id' => Yii::t('app', 'Req ID'),
            'item' => Yii::t('app', 'Item'),
            'codart' => Yii::t('app', 'Codart'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'imptacion' => Yii::t('app', 'Imptacion'),
            'tipim' => Yii::t('app', 'Tipim'),
            'texto' => Yii::t('app', 'Texto'),
            'activo' => Yii::t('app', 'Activo'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'os_id' => Yii::t('app', 'Os ID'),
            'detos_id' => Yii::t('app', 'Detos ID'),
            'ultimo' => Yii::t('app', 'Ultimo'),
            'user_id' => Yii::t('app', 'User ID'),
            'fechaprog' => Yii::t('app', 'Fechaprog'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codal' => Yii::t('app', 'Codal'),
            'codpro' => Yii::t('app', 'Codpro'),
            'servicio_id' => Yii::t('app', 'Servicio ID'),
            'codest' => Yii::t('app', 'Codest'),
            'ceco_id' => Yii::t('app', 'Ceco ID'),
            'detreq_id' => Yii::t('app', 'Detreq ID'),
            'detres_id' => Yii::t('app', 'Detres ID'),
            'ruta' => Yii::t('app', 'Ruta'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'clave' => Yii::t('app', 'Clave'),
            'op_id' => Yii::t('app', 'Op ID'),
        ];
    }

    /**
     * Gets query for [[Codart0]].
     *
     * @return \yii\db\ActiveQuery|MaestrocompoQuery
     */
    public function getOp()
    {
        return $this->hasOne(PrdOp::class, ['id' => 'op_id']);
    }

  

    /**
     * Gets query for [[Req]].
     *
     * @return \yii\db\ActiveQuery|MatReqQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::class, ['codart' => 'codart']);
    }
    
     public function getPadre()
    {
        return $this->hasOne(PrdOpDespiece::class, ['id' => 'parent_id']);
    }

    /**
     * {@inheritdoc}
     * @return PrdOpDespieceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PrdOpDespieceQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->refresh();
            $this->clave='_'.$this->id;
            $this->ruta=$this->pathRoute();
            $this->ruta_larga=$this->pathRoute(false);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function isChild(){
        return $this->parent_id >0;
    }
    
    public function parentCode(){
        return $this->padre->codart;
    }
    
    public function pathRoute($corta=true){
        $nodos=[];
        if(!$this->isChild()){
           $nodos[]='\\' ;
        }else{
          
          $nodos[]=($corta)?$this->padre->codart:$this->padre->codart.'-'.$this->padre->descripcion;
           $nodos[]=$this->padre->pathRoute($corta);            
        }
        return implode('\\', array_reverse($nodos));
    }
    
}

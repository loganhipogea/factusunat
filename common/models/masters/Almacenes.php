<?php

namespace common\models\masters;
use frontend\modules\mat\models\MatStock;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "almacenes".
 *
 * @property string $codal
 * @property string $nomal
 * @property string $tipo
 * @property string $codcen
 * @property string $tipoval tipo valorizacion : promedio, LIFO FIFO
 * @property string $reposicionsololibre solo tomar encuenta el stock libre , no el reservado ni el de transito
 * @property string|null $estructura
 * @property string $novalorado
 * @property float|null $tolstockres Toleracia de merma
 * @property string $codmon
 * @property string $agregarauto
 * @property string $bloqueado
 *
 * @property Centros $codcen0
 */
class Almacenes extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public $booleanFields=[
        'reposicionsololibre', 'novalorado',
        'agregarauto', 'bloqueado'
        ];
    
    
    private $_valortotal=0;
    private $_nitems=null;
    private $_items_valorizados=[];//Array ['id'=>'Valor]
    //private $_=null;
    
    public static function tableName()
    {
        return 'almacenes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codal', 'nomal', 'tipo', 'codcen', 'codmon',], 'required'],
            [['tolstockres'], 'number'],
            [['codal'], 'string', 'max' => 4],
            [['nomal'], 'string', 'max' => 25],
            [['tipo'], 'string', 'max' => 2],
            [['codcen'], 'string', 'max' => 5],
            [['tipoval'], 'string', 'max' => 1],
            [['estructura'], 'string', 'max' => 15],
            [['codmon'], 'string', 'max' => 3],
            [['codal'], 'unique'],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codal' => Yii::t('base.names', 'Código'),
            'nomal' => Yii::t('base.names', 'Nombre'),
            'tipo' => Yii::t('base.names', 'Tipo'),
            'codcen' => Yii::t('base.names', 'Centro'),
            'tipoval' => Yii::t('base.names', 'Tipo Valorización'),
            'reposicionsololibre' => Yii::t('base.names', 'Reposic libre'),
            'estructura' => Yii::t('base.names', 'Estructura'),
            'novalorado' => Yii::t('base.names', 'Materiales no valorados'),
            'tolstockres' => Yii::t('base.names', 'Tolerancia Stock'),
            'codmon' => Yii::t('base.names', 'Moneda'),
            'agregarauto' => Yii::t('base.names', 'Reposición automática'),
            'bloqueado' => Yii::t('base.names', 'Bloqueado'),
        ];
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCodcen0()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    /**
     * {@inheritdoc}
     * @return AlmacenesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlmacenesQuery(get_called_class());
    }
    
    
     public function getItems()
    {
        return $this->hasMany(\frontend\modules\mat\models\MatStock::className(), ['codal' => 'codal']);
    }
    
    
    public function getValor(){
        if($this->_valortotal>0){
            
        }else{
           $this->_valortotal=MatStock::find()->andWhere(['codal'=>$this->codal])->sum('valor');
        }
        return $this->_valortotal;
    }
    
    public function getNitems(){
        if($this->_nitems>0){
            
        }else{
           $this->_nitems=MatStock::find()->andWhere(['codal'=>$this->codal])->count();
        }
        return $this->_nitems;
    }
    
    
    
    
   
   
   
    /*Grupo de funciones para resolver el
    * Diagrama de pareto
    */
   
    public function resolvePareto(){
        $monto=0;
        $montoTotal=$this->valor;
        
        foreach($this->getItems()->
                orderBy(['valor'=>SORT_DESC])
                ->each(10) as $item){
            $monto+=is_null($item->valor)?0:$item->valor;
            if($monto<=$montoTotal*0.8){
                MatStock::updateAll(['abc'=>'A'],['id'=>$item->id]);
            }elseif($monto<=$montoTotal*0.9){
                MatStock::updateAll(['abc'=>'B'],['id'=>$item->id]);
            }else{
                MatStock::updateAll(['abc'=>'C'],['id'=>$item->id]); 
            }
        }
    }
}

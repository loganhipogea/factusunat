<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "subsubfamilia".
 *
 * @property int $id
 * @property int|null $familiasub_id
 * @property string $codsubsubfam
 * @property string|null $codsubfam
 * @property string|null $descrisubsubfam
 */
class SubSubFamilia extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
   public $familia_id; 
    
    public static function tableName()
    {
        return 'subsubfamilia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['familiasub_id'], 'integer'],
            [['codfam'], 'safe'],
            [['codsubsubfam'], 'required'],
            [['codsubsubfam', 'codsubfam'], 'string', 'max' => 2],
            [['descrisubsubfam'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'familiasub_id' => Yii::t('app', 'Familiasub ID'),
            'codsubsubfam' => Yii::t('app', 'Codsubsubfam'),
            'codsubfam' => Yii::t('app', 'Codsubfam'),
            'descrisubsubfam' => Yii::t('app', 'Descrisubsubfam'),
        ];
    }
    
    public function prefix(){
        return $this->codfam.'.'.$this->codsubfam.'.'.$this->codsubsubfam.'-';
    }
    
    
    
    /*
     * Define los items de cualquier nodo 
     * del arbol de materiales , con solo
     * una clave de la forma 
     * 
     * _x_   familia
     * _x_y_ subfamilia
     * _x_y_z_ subsubfamilia
     * 
     * Donde x y z valores enteros que representan el id de la fila
     */
    
    public function items($clave){
       //var_dump($clave);die();
       $veces_se_repite=substr_count($clave, '_');
        if($veces_se_repite==4){ //Clave Nivel 3, toca desarrollar nivel 4
            $models=[];
        }elseif($veces_se_repite==3){//Clave Nivel 2, toca desarrollar nivel 3
            $posinicial=strpos($clave,'_',1);
            $posfinal=strpos($clave,'_',$posinicial+1);
            $filtro=substr($clave,$posinicial+1,$posfinal-$posinicial-1);
           $models= SubSubFamilia::find()->andWhere(['familiasub_id'=>$filtro])->all();
           $namecampo='descrisubsubfam';
           $icon='fa fa-cog';
           
           
            
        }elseif($veces_se_repite==2){//Clave Nivel 1, toca desarrollar nivel 2
           // $filtro=substr(strpos($clave,'_')+1,1)
            $posinicial=0;
            $posfinal=strpos($clave,'_',1);
            $filtro=substr($clave,$posinicial+1,$posfinal-$posinicial-1)+0;
           /*var_dump($clave,$posinicial,$posfinal,$filtro,
                    SubFamilia::find()->andWhere(['familia_id'=>$filtro])->createCommand()->rawSql);die();*/
           $models= SubFamilia::find()->andWhere(['familia_id'=>$filtro])->all();
           $namecampo='descrisubfam';
            $icon='fa fa-cube';
        }else{
            return [];
        }
        $ramas=[];
        foreach($models as $model){
             $ramas[]=[
            'icon'=>$icon,
            'key'=>$clave.$model->id.'_',
            'title'=>$model->prefix().$model->{$namecampo},/*.
                     \yii\helpers\Html::a(   '<i style="color:#6f9e30;"><span class="fa fa-plus-circle"></span></i>',
                    \yii\helpers\Url::to(['/sigi/edificios/agrega-partida-tree','id'=>$fila->id,'gridName'=>'grilla-cuentas','idModal'=>'buscarvalor']),
                        [
                            'class'=>"botonAbre",
                            'title' => yii::t('sta.labels','Agregar Colector'),
                        ]
                    ),*/
            'lazy'=>true,
            'tooltip'=>'fill-grupos-cargo_'.$model->id,
        ];
        }
       return $ramas; 
       
    }
}

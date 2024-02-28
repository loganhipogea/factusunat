<?php

namespace common\models\masters;
use frontend\modules\mat\models\MatDespiece;
use common\behaviors\TreeViewBehavior;
use yii\helpers\Url;
use Yii;

/**
 * This is the model class for table "{{%modelosbase}}".
 *
 * @property int $id
 * @property string|null $descripcion
 * @property string|null $fecha
 */
class Modelosbase extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%modelosbase}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string', 'max' => 40],
            [['fecha'], 'string', 'max' => 10],
        ];
    }
    
    
     public function behaviors() {
        return [
           
             'TreeBehavior' => [
                'class' => TreeViewBehavior::className(),
                
            ],
            
            
           
        ];
    }
    
    
    public function getDespiece(){
        return $this->hasMany(MatDespiece::className(), ['modelobase_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ModelosbaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ModelosbaseQuery(get_called_class());
    }
    
    public function hasPiezas(){
        return $this->getDespiece()->count()>0;
    }
    
    
    /*
     * Solo las piezas del primer nivel
     */
   public function piezasMayores(){
       return $models=$this->getDespiece()->andWhere(['parent_id'=>null])->all();
       
     }
     
  public function urlsTreeViewButtons($idModel){
     return [
         "fa fa-plus"=>[  "url"=>Url::to([
                                            "/masters/modelos-base/modal-crea-nodo",
                                            "id"=>$idModel,
                                            "gridName"=>"ere",
                                             "idModal"=>"buscarValor",
                                        ],[
                                            
                                        ]),
                          "optionsEnlace"=>["class"=>"botonAbre badge btn-success"]
                         ]
                    ,
        /* 'fa fa-trash'=>[  'url'=>  function ($model){
                       return     Url::to([
                                            '/masters/modelos-base/ajax-borra-nodo',
                                            'id'=>$model->id,
                           
                                        ],[
                                            
                                        ]);
                                        },
                          'optionsEnlace'=>[]
                         ],
               */
        "fa fa-times-circle-o"=>[  "url"=>Url::to([
                                            "/masters/modelos-base/agrega-modelo-base",
                                            "id"=>$idModel,
                           
                                        ],[
                                            
                                        ]),
                          "optionsEnlace"=>["target"=>"_blank","class"=>"badge btn-warning"]
                         ],
         "fa fa-eye"=>[  "url"=>Url::to([
                                            "/masters/modelos-base/agrega-modelo-base",
                                            "id"=>$idModel,
                           
                                        ],[
                                            
                                        ]),
                          "optionsEnlace"=>["target"=>"_blank","class"=>"badge btn-danger"]
                         ],
     ];
 }
 
 
 
 
}

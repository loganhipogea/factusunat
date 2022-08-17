<?php
namespace frontend\modules\op\models;
use common\models\FileSearch  as FSearch;
use yii\data\ActiveDataProvider;
use common\models\File as Fileb;
use yii\base\Model;
use common\helpers\FileHelper;
use Yii;
use yii\helpers\Url;
class FileSearch extends FSearch
{
   /*Filtro para los modelos del campo
    * MOdels, un arrtay con valores para discriminar
    * de que modelos se trata
    */ 
   public $proc_id=null; 
   public $os_id=null;   
    public $osdet_id=null;
    public $filterModels=['OpProcesos','OpOS','OpOsdet','OpTareodet'];
    
    
   public function rules()
    {
        $newRules= [
            [['proc_id','osdet_id','os_id'], 'integer'],
            [['proc_id','osdet_id','os_id'], 'safe'],
        ];
        return array_merge(parent::rules(),$newRules);
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function searchByProc($params)
    {
        $query = Fileb::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 5,
                    ]
        ]);
       // print_r($this->rules());die();
        //
        //print_r($params);
        $this->load($params);
        //var_dump($this->proc_id,$this->osdet_id,$this->os_id);die();
        if (!$this->validate()) {
            //'sfsfsfs'=>models();             
            return $dataProvider;
        }
        
        if(!empty($this->proc_id)){
         $modelProc= OpProcesos::findOne($this->proc_id);
         //$this->filterModels=['OpProcesos','OpOS','OpOsdet','OpTareodet'];
         //$query->andWhere(['model'=>'OpProcesos','itemId'=>$this->proc_id]);
            if(empty($this->osdet_id)){
                     $query->andFilterWhere([
                   'or',
                   ['model'=>'OpOs','itemId'=>$modelProc->idsOs()],
                   ['model'=>'OpOsdet','itemId'=>$modelProc->idsDetos()],
                   ['model'=>'OpLibro','itemId'=>$modelProc->idsOpLibros()],
                  ]) ;
                }else{
                $query->andFilterWhere([
                   'or',                  
                   ['model'=>'OpOsdet','itemId'=>$this->osdet_id],
                   ['model'=>'OpLibro','itemId'=>$modelProc->idsOpLibros()],
                 ]) ;
                }
                     
          } else{
             if(!empty($this->filterModels))
            $query->andFilterWhere([
                    'in',
                    'model', $this->filterModels,
                ]);   
          }       
         
       
        $query->andFilterWhere(['codocu'=> $this->codocu])
            ->andFilterWhere(['type'=> $this->type])
            ->andFilterWhere(['like','titulo', $this->titulo])
            ->andFilterWhere(['like','detalles', $this->detalle])
            ;
         if(!empty($this->cuando) && !empty($this->cuando1)){
                            $query->andFilterWhere([
                                    'between',
                                    'cuando',
                                $this->cuando,
                                $this->cuando1
                                ]);   
                        }
         if(!empty($this->size) && !empty($this->size1)){
                            $query->andFilterWhere([
                                    'between',
                                    'size',
                                    $this->size-0.001,
                                    $this->size1+0.001
                                ]);
                
            }
            echo $query->createCommand()->rawSql; die();
         return $dataProvider;
  }
}

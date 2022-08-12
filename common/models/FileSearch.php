<?php
namespace common\models;
use common\models\File as Fileb;
use yii\base\Model;
//use nemmo\attachments\ModuleTrait;
use common\helpers\FileHelper;
use yii\data\ActiveDataProvider;
use Yii;
use yii\helpers\Url;
class FileSearch extends Fileb
{
   /*Filtro para los modelos del campo
    * MOdels, un arrtay con valores para discriminar
    * de que modelos se trata
    */ 
   public $filterModels=[]; 
   public $size1=null;   
    public $cuando1=null;
    public function attributeLabels()
    {
        $labels=[
            'size1' => Yii::t('base.names', 'Tamaño'),
            'cuando1' => Yii::t('base.names', 'F. subida'),
            //'durationabsolute' => Yii::t('base.names', 'Duracion absoluta'),
        ];
      return parent::attributeLabels()+$labels;
    }
   public function rules()
    {
        return [
            [['id','user_id','itemId'], 'integer'],
            [['name', 'size','size1', 'model', 'itemId', 'descripcion', 'type', 'detalle','titulo','codocu','cuando','cuando1','user_id'], 'safe'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Fileb::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        if(!empty($this->filterModels))
            $query->andFilterWhere([
                    'in',
                    'model', $this->filterModels,
                ]);
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
                return $dataProvider;
            }
  }
}

<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatStock;
use codiverum\relationSF\RelationSFTrait;
/**
 * MatReqSearch represents the model behind the search form of `frontend\modules\mat\models\MatReq`.
 */
class MatStockSearch extends MatStock
{
    
    public $material;
    use RelationSFTrait;
    /**
     * {@inheritdoc}
     */
   
    
    
    
    
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codart', 'material','fechaprog', 'fechasol', 'codtra', 'material.descripcion', 'texto', 'codest','semaforo'], 'safe'],
            //['material.descripcion', 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MatStock::find();
        $this->joinWithRelation($query, 'material');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->addRelationSort($dataProvider, 'material', 'descripcion','maestrocompo');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', $this->tableName().'.codart', $this->codart]);
        $query->andFilterWhere(['semaforo'=>$this->semaforo]);
         $this->addRelationFilter($query, 'material', 'descripcion','maestrocompo');
        return $dataProvider;
    }
}

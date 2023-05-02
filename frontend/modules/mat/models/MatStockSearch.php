<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatStock;

/**
 * MatReqSearch represents the model behind the search form of `frontend\modules\mat\models\MatReq`.
 */
class MatStockSearch extends MatStock
{
    /**
     * {@inheritdoc}
     */
   
    public function attributes()
        {
         // add related fields to searchable attributes
            return array_merge(parent::attributes(), ['material.descripcion']);
        }

    
    
    
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codart', 'fechaprog', 'fechasol', 'codtra', 'descripcion', 'texto', 'codest'], 'safe'],
            ['material.descripcion', 'safe'],
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

        // add conditions that should always apply here

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
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['LIKE', 'material.descripcion', $this->getAttribute('material.descripcion')])
            ->andFilterWhere(['like', 'codart', $this->codart])
             ;

        return $dataProvider;
    }
}

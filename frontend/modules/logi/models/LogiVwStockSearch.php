<?php

namespace frontend\modules\logi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\logi\models\LogiVwStock;

/**
 * StockSearch represents the model behind the search form of `frontend\modules\logi\models\Stock`.
 */
class LogiVwStockSearch extends LogiVwStock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codart', 'codcen', 'um','pventa', 'ubicacion', 'codal', 'descripcion', 'marca','modelo','valortotal'], 'safe'],
            [['cant',  'valor','pventa','valortotal'], 'number'],
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
        $query = LogiVwStock::find();

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
           // 'id' => $this->id,
            'codcen' => $this->codcen,
            'codal' => $this->codal,
           
        ]);

        $query->andFilterWhere(['like', 'codart', $this->codart])
            ->andFilterWhere(['like', 'descripcion', explode ('%',$this->descripcion)])
            ->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'modelo', $this->modelo]);
       // echo $query->createCommand()->rawSql; die();
             //YII::ERROR($query->createCommand()->rawSql);
        return $dataProvider;
    }
}

<?php

namespace frontend\modules\logi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\logi\models\Stock;

/**
 * StockSearch represents the model behind the search form of `frontend\modules\logi\models\Stock`.
 */
class StockSearch extends Stock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codart', 'codcen', 'um', 'ubicacion', 'codal', 'lastmov', 'clas_abc'], 'safe'],
            [['cant', 'cantres', 'valor', 'pventa', 'ceconomica', 'creorden', 'cminima'], 'number'],
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
        $query = Stock::find();

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
            'cant' => $this->cant,
            'cantres' => $this->cantres,
            'valor' => $this->valor,
            'pventa' => $this->pventa,
            'ceconomica' => $this->ceconomica,
            'creorden' => $this->creorden,
            'cminima' => $this->cminima,
        ]);

        $query->andFilterWhere(['like', 'codart', $this->codart])
            ->andFilterWhere(['like', 'codcen', $this->codcen])
            ->andFilterWhere(['like', 'um', $this->um])
            ->andFilterWhere(['like', 'ubicacion', $this->ubicacion])
            ->andFilterWhere(['like', 'codal', $this->codal])
            ->andFilterWhere(['like', 'lastmov', $this->lastmov])
            ->andFilterWhere(['like', 'clas_abc', $this->clas_abc]);

        return $dataProvider;
    }
}

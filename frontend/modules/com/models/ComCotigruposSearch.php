<?php

namespace frontend\modules\com\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\com\models\ComCotigrupos;

/**
 * ComCotigruposSearch represents the model behind the search form of `frontend\modules\com\models\ComCotigrupos`.
 */
class ComCotigruposSearch extends ComCotigrupos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'coti_id'], 'integer'],
            [['descripartida', 'calificacion', 'item'], 'safe'],
            [['total'], 'number'],
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
        $query = ComCotigrupos::find();

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
            'total' => $this->total,
            'coti_id' => $this->coti_id,
        ]);

        $query->andFilterWhere(['like', 'descripartida', $this->descripartida])
            ->andFilterWhere(['like', 'calificacion', $this->calificacion])
            ->andFilterWhere(['like', 'item', $this->item]);

        return $dataProvider;
    }
}

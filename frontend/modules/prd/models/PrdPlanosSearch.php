<?php

namespace frontend\modules\prd\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\prd\models\PrdPlanos;

/**
 * PrdPlanosSearch represents the model behind the search form of `frontend\modules\prd\models\PrdPlanos`.
 */
class PrdPlanosSearch extends PrdPlanos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'activo_id', 'matdespiece_id'], 'integer'],
            [['codart', 'descriplano', 'comentario', 'rol', 'fecha', 'revision', 'codigo', 'current_status', 'status'], 'safe'],
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
        $query = PrdPlanos::find();

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
            'activo_id' => $this->activo_id,
            'matdespiece_id' => $this->matdespiece_id,
        ]);

        $query->andFilterWhere(['like', 'codart', $this->codart])
            ->andFilterWhere(['like', 'descriplano', $this->descriplano])
            ->andFilterWhere(['like', 'comentario', $this->comentario])
            ->andFilterWhere(['like', 'rol', $this->rol])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'revision', $this->revision])
            ->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'current_status', $this->current_status])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}

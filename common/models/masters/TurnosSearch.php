<?php

namespace common\models\masters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\masters\Turnos;

/**
 * TurnosSearch represents the model behind the search form of `common\models\masters\Turnos`.
 */
class TurnosSearch extends Turnos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codarea_id', 'desturno', 'detalle', 'activo'], 'safe'],
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
        $query = Turnos::find();

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

        $query->andFilterWhere(['like', 'codarea_id', $this->codarea_id])
            ->andFilterWhere(['like', 'desturno', $this->desturno])
            ->andFilterWhere(['like', 'detalle', $this->detalle])
            ->andFilterWhere(['like', 'activo', $this->activo]);

        return $dataProvider;
    }
}

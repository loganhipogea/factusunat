<?php

namespace common\models\masters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\masters\Cargos;

/**
 * CargosSerch represents the model behind the search form of `common\models\masters\Cargos`.
 */
class CargosSerch extends Cargos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['descricargo', 'codcargo'], 'safe'],
            [['hh'], 'number'],
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
        $query = Cargos::find();

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
            'hh' => $this->hh,
        ]);

        $query->andFilterWhere(['like', 'descricargo', $this->descricargo])
            ->andFilterWhere(['like', 'codcargo', $this->codcargo]);

        return $dataProvider;
    }
}

<?php

namespace common\models\masters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\masters\Transacciones;

/**
 * TransaccionesSearch represents the model behind the search form of `common\models\masters\Transacciones`.
 */
class TransaccionesSearch extends Transacciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtrans', 'descripcion', 'detalles'], 'safe'],
            [['signo'], 'integer'],
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
        $query = Transacciones::find();

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
            'signo' => $this->signo,
        ]);

        $query->andFilterWhere(['like', 'codtrans', $this->codtrans])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'detalles', $this->detalles]);

        return $dataProvider;
    }
}

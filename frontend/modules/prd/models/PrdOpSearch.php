<?php

namespace frontend\modules\prd\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\prd\models\PrdOp;

/**
 * PrdOpSearch represents the model behind the search form of `frontend\modules\prd\models\PrdOp`.
 */
class PrdOpSearch extends PrdOp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'avance'], 'integer'],
            [['numero', 'codart', 'descripcion', 'textodetalle', 'textocomercial', 'username', 'finicio', 'finiciop', 'ftermino', 'fterminop', 'fcrea', 'tipo', 'codestado'], 'safe'],
            [['cant'], 'number'],
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
        $query = PrdOp::find();

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
            'parent_id' => $this->parent_id,
            'cant' => $this->cant,
            'avance' => $this->avance,
        ]);

        $query->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'codart', $this->codart])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'textodetalle', $this->textodetalle])
            ->andFilterWhere(['like', 'textocomercial', $this->textocomercial])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'finicio', $this->finicio])
            ->andFilterWhere(['like', 'finiciop', $this->finiciop])
            ->andFilterWhere(['like', 'ftermino', $this->ftermino])
            ->andFilterWhere(['like', 'fterminop', $this->fterminop])
            ->andFilterWhere(['like', 'fcrea', $this->fcrea])
            ->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'codestado', $this->codestado]);

        return $dataProvider;
    }
}

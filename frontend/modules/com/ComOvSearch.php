<?php

namespace frontend\modules\com;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\com\models\ComOv;

/**
 * ComOvSearch represents the model behind the search form of `frontend\modules\com\models\ComOv`.
 */
class ComOvSearch extends ComOv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['rucodni', 'codcen', 'codsoc', 'tipodoc', 'tipopago', 'numero'], 'safe'],
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
        $query = ComOv::find();

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

        $query->andFilterWhere(['like', 'rucodni', $this->rucodni])
            ->andFilterWhere(['like', 'codcen', $this->codcen])
            ->andFilterWhere(['like', 'codsoc', $this->codsoc])
            ->andFilterWhere(['like', 'tipodoc', $this->tipodoc])
            ->andFilterWhere(['like', 'tipopago', $this->tipopago])
            ->andFilterWhere(['like', 'numero', $this->numero]);

        return $dataProvider;
    }
}

<?php

namespace frontend\modules\com\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\com\models\ComCotizacion;

/**
 * ComCotizacionSearch represents the model behind the search form of `frontend\modules\com\models\ComCotizacion`.
 */
class ComCotizacionSearch extends ComCotizacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'validez', 'n_direcc'], 'integer'],
            [['numero', 'serie', 'codsoc', 'codcen', 'codcli', 'codcli1', 'estado', 'descripcion', 'detalle_interno', 'detalle_externo', 'femision', 'codtra', 'codmon'], 'safe'],
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
        $query = ComCotizacion::find();

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
            'validez' => $this->validez,
            'n_direcc' => $this->n_direcc,
        ]);

        $query->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'serie', $this->serie])
            ->andFilterWhere(['like', 'codsoc', $this->codsoc])
            ->andFilterWhere(['like', 'codcen', $this->codcen])
            ->andFilterWhere(['like', 'codcli', $this->codcli])
            ->andFilterWhere(['like', 'codcli1', $this->codcli1])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'detalle_interno', $this->detalle_interno])
            ->andFilterWhere(['like', 'detalle_externo', $this->detalle_externo])
            ->andFilterWhere(['like', 'femision', $this->femision])
            ->andFilterWhere(['like', 'codtra', $this->codtra])
            ->andFilterWhere(['like', 'codmon', $this->codmon]);

        return $dataProvider;
    }
}

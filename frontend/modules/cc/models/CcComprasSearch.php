<?php

namespace frontend\modules\cc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\cc\models\CcCompras;

/**
 * CcCuentasSearch represents the model behind the search form of `frontend\modules\cc\models\CcCuentas`.
 */
class CcComprasSearch extends CcCompras
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [[ 'parent_id','id','rucpro','codmon', 'codpro', 'glosa', 'numero','codocu', 'activo','monto'], 'safe'],
          
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
        $query = CcCompras::find();

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
            'banco_id' => $this->banco_id,
            'saldo' => $this->saldo,
        ]);

        $query->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'codmon', $this->codmon])
            ->andFilterWhere(['like', 'codpro', $this->codpro])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'socio', $this->socio])
            ->andFilterWhere(['like', 'detalles', $this->detalles])
            ->andFilterWhere(['like', 'indicaciones', $this->indicaciones])
            ->andFilterWhere(['like', 'indicaciones2', $this->indicaciones2])
            ->andFilterWhere(['like', 'activa', $this->activa])
            ->andFilterWhere(['like', 'cci', $this->cci])
            ->andFilterWhere(['like', 'fecult', $this->fecult]);

        return $dataProvider;
    }
    
    public function searchByFondo($id,$params)
    {
        $query = CcCompras::find();

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
        $query->andWhere(['parent_id'=>$id]);
        // grid filtering conditions
       /* $query->andFilterWhere([
            'id' => $this->id,
            'banco_id' => $this->banco_id,
            'saldo' => $this->saldo,
        ]);*/

        $query->andFilterWhere(['like', 'glosa', $this->glosa])
            ->andFilterWhere(['like', 'rucpro', $this->rucpro])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['codocu'=>$this->codocu]);

        return $dataProvider;
    }
}

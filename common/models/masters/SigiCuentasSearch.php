<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiCuentas;

/**
 * SigiCargosSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiCargos`.
 */
class SigiCuentasSearch extends SigiCuentas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['codmon','codpro','nombre','tipo','edificio_id'], 'safe'],
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
    public function searchByEdificio($edificio_id)
    {
        $query = SigiCuentas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->where([
            'edificio_id' => $edificio_id,
           // 'npisos' => $this->npisos,
        ]);
        // grid filtering conditions
        
        return $dataProvider;
    }
    
     public function search($params)
    {
        $query = SigiCuentas::find();

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
            //'id' => $this->id,
            'edificio_id' => $this->edificio_id,
            'tipo' => $this->tipo,
            'codpro' => $this->codpro,
            'codmon' => $this->codmon,
        ]);

       
        return $dataProvider;
    }
}

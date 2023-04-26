<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatReq;

/**
 * MatReqSearch represents the model behind the search form of `frontend\modules\mat\models\MatReq`.
 */
class VwValeSearch extends VwVale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['descripcion', 'codart', 'numero','codal',
                'fecha','fecha1','fechacon','codmov',
                
                'fechacon1'], 'safe'],
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
    public function search_by_req($idreq)
    {
        $query = VwVale::find();

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
        
        $query->andFilterWhere(['like', 'codart', $this->codart])
           // ->andFilterWhere(['like', 'descripcion', $this->descripcion])
           ->andFilterWhere(['like', 'numero', $this->numero])
           // ->andFilterWhere(['like', 'fechasol', $this->fechasol])
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])
                
                ;
        if(!empty($this->descripcion))
        $query->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)]);
//echo $query->createCommand()->rawSql;
        return $dataProvider;
    }
    
     public function search($params)
    {
        $query = VwVale::find();

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
        

        $query->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['codmov'=> $this->codmov])
            //->andFilterWhere(['like', 'item', $this->item])
            ->andFilterWhere(['like', 'codart', $this->codart])
            ->andFilterWhere(['codal'=> $this->codal])
           ->andFilterWhere(['like', 'descripcion', $this->descripcion])
           ->andFilterWhere(['like', 'despro', $this->despro])
                ->andFilterWhere(['like', 'um', $this->um])
            //->andFilterWhere(['like', 'cant', $this->texto])
            ->andFilterWhere(['like', 'cant', $this->cant]);
         if(!empty($this->fecha) && !empty($this->fecha1)){
         $query->andFilterWhere([
             'between',
             'fecha',
             $this->openBorder('fecha',false),
             $this->openBorder('fecha1',true)
                        ]);   
        }
        
         if(!empty($this->fechacon) && !empty($this->fechacon1)){
         $query->andFilterWhere([
             'between',
             'fechacon',
             $this->openBorder('fechacon',false),
             $this->openBorder('fechacon1',true)
                        ]);   
        }

        return $dataProvider;
    }
    
    
}

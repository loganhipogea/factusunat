<?php

namespace frontend\modules\op\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\op\models\OpOs;

/**
 * MatReqSearch represents the model behind the search form of `frontend\modules\mat\models\MatReq`.
 */
class OpOsSearch extends OpOs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['descripcion','numero', 'textotecnico', 'textointerno','orden','ot'], 'safe'],
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
        $query = OpOs::find();

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

       
       
        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
       //->andFilterWhere(['like', 'textointerno', $this->textointerno])
        ->andFilterWhere(['like', 'orden', $this->orden])
          ->andFilterWhere(['like', 'ot', $this->ot])
                //
                ;      
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])
                
               // ;
        
//echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
}

<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatDetvale;
use frontend\modules\mat\models\MatDetreq;

/**
 * MatReqSearch represents the model behind the search form of `frontend\modules\mat\models\MatReq`.
 */
class MatVwIngresosSearch extends MatVwIngresos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['descri','numero', 'codcen', 'fecha','fecha1', 'codart','rotativo'], 'safe'],
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
        $query = MatVwIngresos::find();

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

        
       
        $query->andFilterWhere(['like', 'codart', $this->codart])
       ->andFilterWhere(['like', 'descri', explode('%',$this->descri)])   
       ->andFilterWhere(['rotativo'=>$this->rotativo])   
        ->andFilterWhere(['like', 'numero', $this->numero])
        ->andFilterWhere(['codcen'=>$this->codcen])
                 ->andFilterWhere(['codcencli'=>$this->codcencli])
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])                  
                ;
        
         if(!empty($this->fechal) && !empty($this->fecha)){
         $query->andFilterWhere([
             'between',
             'fecha',
             $this->openBorder('fecha',false),
             $this->openBorder('fecha1',true)
                        ]);   
        }
        
         
       // echo  $query->createCommand()->rawSql;DIE();
        return $dataProvider;
    }
    
   
}

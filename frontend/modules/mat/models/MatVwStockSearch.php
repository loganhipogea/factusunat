<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatVwStock;

class MatVwStockSearch extends MatVwStock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['id','codal', 'codart', 'codum', 'valor',
                'punit','descripcion','ubicacion','cantres','cant_disp',
                'semaforo','valor_unit'], 'safe'],
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
        $query = MatVwStock::find();

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

        
       
       if(empty($this->descripcion)){
           $query->andFilterWhere(['like', 'pìc', $this->codart])
       ->andFilterWhere(['like', 'ubicacion', $this->ubicacion])
        ->andFilterWhere(['semaforo'=>$this->semaforo])
        ->andFilterWhere(['>','valor',$this->valor])
         ->andFilterWhere(['>','valor_unit',$this->valor_unit])         
         //->andWhere($likeCondition)
        ->andFilterWhere(['codal'=>$this->codal]);
       }ELSE{
           $likeCondition = new \yii\db\conditions\LikeCondition('descripcion', 'LIKE','%'.$this->descripcion.'%');
                    $likeCondition->setEscapingReplacements(false);
                $query->andWhere($likeCondition);
       }
        
           
        return $dataProvider;
    }
    
  
   
}

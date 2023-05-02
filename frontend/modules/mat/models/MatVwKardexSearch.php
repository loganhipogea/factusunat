<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatVwKardex;

class MatVwKardexSearch extends MatVwKardex
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['codmov','codal', 'codart', 'codpro', 'valor',
                'punit','descripcion','despro','fecha','fecha1',
                ], 'safe'],
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
        $query = MatVwKardex::find();

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
        ->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])
       ->andFilterWhere(['codmov'=>$this->codmov])
      ->andFilterWhere(['codocu'=>$this->codocu])
       ->andFilterWhere(['codpro'=>$this->codpro])
       ->andFilterWhere(['codal'=>$this->codal])
        ->andFilterWhere(['like', 'numerodoc', $this->numerodoc])
        //->andFilterWhere(['semaforo'=>$this->semaforo])
        ->andFilterWhere(['>','valor',$this->valor])        
        ;
           // ->andFilterWhere(['like', 'fechasol', $this->fechasol])
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])                  
        if(!empty($this->fecha) && !empty($this->fecha1)){
         $query->andFilterWhere([
             'between',
             'fecha',
             $this->openBorder('fecha',false),
             $this->openBorder('fecha1',true)
                        ]);   
        } 
        
        //echo  $query->createCommand()->rawSql;DIE();
        return $dataProvider;
    }
    
   public function getProveedor()
    {
        return $this->hasOne(\common\models\masters\Clipro::className(), ['codpro' => 'codpro']);
    }
   public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['codart' => 'codart']);
    }
}

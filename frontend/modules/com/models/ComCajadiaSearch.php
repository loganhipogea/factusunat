<?php

namespace frontend\modules\com\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\com\models\ComFactura;

/**
 * ComFacturaSearch represents the model behind the search form of `frontend\modules\com\models\ComFactura`.
 */
class ComCajadiaSearch extends ComCajadia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [[
                'monto_papel','monto_efectivo',
                'fecha','fecha1','monto_papel1','monto_efectivo1','codcen',
                
                ], 'safe'],
            [['monto_papel1','monto_efectivo1'], 'number'],
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
        $query = ComCajadia::find();

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
           'codcen' => $this->codcen,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]) ;
                
               if(!empty($this->fecha) && !empty($this->fecha1)){
                            $query->andFilterWhere([
                                    'between',
                                    'fecha',
                                $this->openBorder('fecha',false),
                                $this->openBorder('fecha1',false)
                                ]);   
                        }
              if(!empty($this->monto_efectivo) && !empty($this->monto_efectivo1)){
                            $query->andFilterWhere([
                                    'between',
                                    'monto_efectivo',
                                    $this->total-0.001,
                                    $this->total1+0.001
                                ]);
              }
              if(!empty($this->monto_papel) && !empty($this->monto_papel1)){
                            $query->andFilterWhere([
                                    'between',
                                    'monto_papel',
                                    $this->total-0.001,
                                    $this->total1+0.001
                                ]);
              }
              //echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
}

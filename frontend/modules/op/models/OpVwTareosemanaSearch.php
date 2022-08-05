<?php

namespace frontend\modules\op\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\op\models\OpTareo;
use common\models\masters\Trabajadores;

/**
 * OpTareoSearch represents the model behind the search form of `frontend\modules\op\models\OpTareo`.
 */
class OpVwTareosemanaSearch extends OpVwTareosemana
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'proc_id','codtra','semana','ap','nombres','codpuesto',
                'semana','numero','descripcion',
                'costo', 'costo1', 
               
                
                ], 'safe'],
            [
                ['proc_id'], 'integer',
                
                
                ],
            
        ];
    }
/**
 * @property string $costo
 * @property string $htotales
 *
 * @property Trabajadores $codtra0
 * @property OpOs $os
 * @property OpTareo $tareo
 * @property OpProcesos $proc
 * @property OpOsdet $detos
 * @property OpPlanestarifa $tarifa
 */
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
  public function getTrabajador()
    {
        return $this->hasOne(\common\models\masters\Trabajadores::className(), ['codigotra' => 'codtra']);
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
        $query = OpVwTareosemana::find();

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
        $query->andFilterWhere(['codtra'=> $this->codtra]) ;
        $query->andFilterWhere(['like', 'ap', $this->ap])
          ->andFilterWhere(['like', 'nombres', $this->nombres])
        
           ->andFilterWhere(['like', 'descripcion', $this->descripcion])
          ->andFilterWhere(['like', 'numero', $this->numero])
            ;
        
   if(!empty($this->semana) && !empty($this->semana1)){
                            $query->andFilterWhere([
                                    'between',
                                    'semana',
                                ($this->semana==1)?$this->semana:$this->semana-1,
                                $this->semana1+1
                                ]);   
                        }
      if(!empty($this->costo) && !empty($this->costo1)){
                            $query->andFilterWhere([
                                    'between',
                                    'costo',
                                $this->costo,
                                $this->costo1
                                ]);   
                        }  
       
        return $dataProvider;
    }
}

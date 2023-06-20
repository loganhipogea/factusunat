<?php

namespace frontend\modules\cc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\cc\models\CcCompras;
use common\models\masters\Clipro;

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
            [[ 'parent_id','id','rucpro','codmon', 'codpro',
                'glosa', 'numero','codocu', 'activo','monto',
                'monto1','fecha1'
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
            
        ]);
        $query->andFilterWhere(['like', 'rucpro', $this->rucpro])
            ->andFilterWhere(['codmon'=> $this->codmon])
            ->andFilterWhere(['codpro'=>$this->codpro])
            ->andFilterWhere(['codocu'=> $this->codocu])
            ->andFilterWhere(['like', 'numero', $this->numero])
             ->andFilterWhere(['like', 'glosa', $this->glosa])
            ;
        if(!empty($this->fecha) && !empty($this->fecha1)){
                            $query->andFilterWhere([
                                    'between',
                                    'fecha',
                                $this->openBorder('fecha',false),
                                $this->openBorder('fecha1',true)
                                ]);   
                        }
      if(!empty($this->monto) && !empty($this->monto1)){
                            $query->andFilterWhere([
                                    'between',
                                    'monto',
                                $this->monto-0.001,
                                $this->monto1+0.001
                                ]);   
        
                }
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
    
   public function getProveedor()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    } 
    
}

<?php

namespace frontend\modules\cc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\cc\models\CcMovimientos;

/**
 * CcCuentasSearch represents the model behind the search form of `frontend\modules\cc\models\CcCuentas`.
 */
class CcMovimientosSearch extends CcMovimientos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caja_id','user_id'], 'integer'],
            [[ 'caja_id','user_id','fechaop','fechaop1','glosa',
                'monto', 'detalle', 'tipo','estado','monto1',
                'igv','cuenta_id','codtra'], 'safe'],
          
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
        $query = CcMovimientos::find();

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
            'cuenta_id' => $this->cuenta_id,
            //'saldo' => $this->saldo,
        ]);

        $query->andFilterWhere(['like', 'igv', $this->igv])
            ->andFilterWhere(['like', 'glosa', $this->glosa])
           // ->andFilterWhere(['like', 'monto', $this->monto])
           
            ;
     if(!empty($this->fechaop) && !empty($this->fechaop1)){
                            $query->andFilterWhere([
                                    'between',
                                    'fechaop',
                                $this->openBorder('fechaop',false),
                                $this->openBorder('fechaop1',true)
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
           //echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
    
  public function getTrabajador()
    {
        return $this->hasOne(\common\models\masters\Trabajadores::className(), ['codigotra' => 'codtra']);
    } 
}

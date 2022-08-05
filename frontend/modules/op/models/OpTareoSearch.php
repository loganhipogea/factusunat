<?php

namespace frontend\modules\op\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\op\models\OpTareo;
USE common\models\masters\Direcciones;
/**
 * OpTareoSearch represents the model behind the search form of `frontend\modules\op\models\OpTareo`.
 */
class OpTareoSearch extends OpTareo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'direcc_id', 'proc_id', 'os_id', 'detos_id'], 'integer'],
            [['fecha','fecha1','direcc_id', 'hinicio', 'hfin', 'descripcion', 'detalle','semana','semana1'], 'safe'],
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
public function getDirecc()
    {
        return $this->hasOne(Direcciones::className(), ['id' => 'direcc_id']);
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
        $query = OpTareo::find();

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
            'direcc_id' => $this->direcc_id,
            'proc_id' => $this->proc_id,
            'os_id' => $this->os_id,
            'detos_id' => $this->detos_id,
        ]);

        $query->andFilterWhere(['like', 'hinicio', $this->hinicio])
            ->andFilterWhere(['like', 'hfin', $this->hfin])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'detalle', $this->detalle]);
      if(!empty($this->fecha) && !empty($this->fecha1)){
                            $query->andFilterWhere([
                                    'between',
                                    'fecha',
                                $this->openBorder('fecha',false),
                                $this->openBorder('fecha1',true)
                                ]);   
                        }
       if(!empty($this->semana) && !empty($this->semana1)){
                            $query->andFilterWhere([
                                    'between',
                                    'semana',
                                ($this->semana==1)?$this->semana:$this->semana-1,
                                $this->semana1+1
                                ]);   
                        }
        return $dataProvider;
    }
}

<?php

namespace frontend\modules\com\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\com\models\ComFactura;

/**
 * ComFacturaSearch represents the model behind the search form of `frontend\modules\com\models\ComFactura`.
 */
class ComFacturaSearch extends ComFactura
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [[
                'codsoc', 'numero', 'femision','femision1', 
                'fvencimiento', 'fvencimiento1','sunat_tipodoc',
                'codmon', 'tipopago', 'rucpro', 'sunat_hemision',
                'codcen', 'serie', 'codestado', 'nombre_cliente',
                'hemision','total1','total','flag_sunat'
                
                ], 'safe'],
            [['sunat_totgrav', 'sunat_totexo', 'sunat_totigv', 'sunat_totimpuestos', 'descuento', 'subtotal', 'sunat_totisc', 'totalventa', 'total'], 'number'],
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
        $query = ComFactura::find();

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
           'tipopago' => $this->tipopago,
            'sunat_tipodoc' => $this->sunat_tipodoc,
             'codmon' => $this->codmon,
             'codcen' => $this->codcen,
            'codsoc' => $this->codsoc,
            'codestado' => $this->codestado,
            'flag_sunat' => $this->flag_sunat,
            /* 'sunat_totexo' => $this->sunat_totexo,
            'sunat_totigv' => $this->sunat_totigv,
            'sunat_totimpuestos' => $this->sunat_totimpuestos,
            'descuento' => $this->descuento,
            'subtotal' => $this->subtotal,
            'sunat_totisc' => $this->sunat_totisc,
            'totalventa' => $this->totalventa,
            'total' => $this->total,*/
        ]);

        $query->andFilterWhere(['like', 'numero', $this->numero])
            //->andFilterWhere(['like', 'femision', $this->femision])
           // ->andFilterWhere(['like', 'fvencimiento', $this->fvencimiento])
            //->andFilterWhere(['like', 'sunat_tipodoc', $this->sunat_tipodoc])
           // ->andFilterWhere(['like', 'codmon', $this->codmon])
            //->andFilterWhere(['like', 'tipopago', $this->tipopago])
            ->andFilterWhere(['like', 'rucpro', $this->rucpro])
           // ->andFilterWhere(['like', 'sunat_hemision', $this->sunat_hemision])
            //->andFilterWhere(['like', 'codcen', $this->codcen])
            ->andFilterWhere(['like', 'serie', $this->serie])
            //->andFilterWhere(['like', 'codestado', $this->codestado])
            ->andFilterWhere(['like', 'nombre_cliente', $this->nombre_cliente]);
                if(!empty($this->femision) && !empty($this->femision1)){
                            $query->andFilterWhere([
                                    'between',
                                    'femision',
                                $this->openBorder('femision',false),
                                $this->openBorder('femision1',true)
                                ]);   
                        }
               if(!empty($this->fvencimiento) && !empty($this->fvencimiento1)){
                            $query->andFilterWhere([
                                    'between',
                                    'fvencimiento',
                                $this->openBorder('fvencimiento',false),
                                $this->openBorder('fvencimiento',true)
                                ]);   
                        }
              if(!empty($this->total) && !empty($this->total1)){
                            $query->andFilterWhere([
                                    'between',
                                    'total',
                                    $this->total-0.001,
                                    $this->total1+0.001
                                ]);
              }
              $query->orderBy(['id'=>SORT_DESC]);
        return $dataProvider;
    }
}

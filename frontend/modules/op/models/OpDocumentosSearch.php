<?php

namespace frontend\modules\op\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\op\models\OpDocumentos;

/**
 * MatReqSearch represents the model behind the search form of `frontend\modules\mat\models\MatReq`.
 */
class OpDocumentosSearch extends OpDocumentos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['descripcion','detalles', 'codocu', 'proc_id','detos_id','os_id'], 'safe'],
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
    public function searchByProc($params,$id)
    {
        $query = OpDocumentos::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        \yii::error($params,__FUNCTION__);
        \yii::error($this->attributes,__FUNCTION__);
        $this->load($params);
       \yii::error($this->attributes,__FUNCTION__);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'proc_id' => $id,
           
        ]);
        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
       ->andFilterWhere(['like', 'detalles', $this->detalles])
        ->andFilterWhere(['os_id'=> $this->os_id])
          ->andFilterWhere(['codocu'=> $this->codocu])       
          ->andFilterWhere(['detos_is'=> $this->detos_id]);
        return $dataProvider;
    }
}

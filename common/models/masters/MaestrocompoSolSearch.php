<?php

namespace common\models\masters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\masters\MaestrocompoSol;

/**
 * MaestrocliproSearch represents the model behind the search form of `common\models\masters\Maestroclipro`.
 */
class MaestrocompoSolSearch extends MaestrocompoSol
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          
            [['descrimanual', 'codart', 'descripcion', 'caracteristicas', 'infotecnica','fecha_cre','proyecto','activo','user_name'], 'safe'],
           
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
        $query = MaestrocompoSol::find();

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
          $query->andFilterWhere(['like', 'descrimanual', $this->descrimanual])
            ->andFilterWhere(['like', 'codart', $this->codart])
             ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'caracteristicas', $this->caracteristicas]);    
         }else{
                    $likeCondition = new \yii\db\conditions\LikeCondition('descripcion', 'LIKE','%'.$this->descripcion.'%');
                    $likeCondition->setEscapingReplacements(false);
                $query->andWhere($likeCondition);
         }
         if(!empty($this->proyecto)){
             $likeCondition = new \yii\db\conditions\LikeCondition('proyecto', 'LIKE','%'.$this->proyecto.'%');
                    $likeCondition->setEscapingReplacements(false);
                $query->andWhere($likeCondition);
         }
        return $dataProvider;
    }
    
    
    
}

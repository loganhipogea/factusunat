<?php

namespace common\models\masters;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * This is the model class for table "vw_cuadrillas".
 *
 * @property int $id
 * @property int|null $cuadrilla_id
 * @property string|null $codcuadrilla_id
 * @property int|null $trabajador_id
 * @property string|null $codtra_id
 * @property string|null $textodetalle
 * @property int $idcuadrilla
 * @property string|null $codcuadrilla
 * @property string|null $descricuadrilla
 * @property string $codigotra
 * @property string $nombres
 * @property string $codarea
 * @property string|null $desarea
 */
class VwCuadrillasSearch extends VwCuadrillas
{
   
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombres', 'codigotra', 'codcuadrilla','descricuadrilla'], 'safe'],
             [['cuadrilla_id', 'trabajador_id', 'codtra_id'], 'integer'],
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
        $query = VwCuadrillas::find();

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

      

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'codigotra', $this->codigotra])
            ->andFilterWhere(['like', 'codcuadrilla', $this->codcuadrilla])
            ->andFilterWhere(['like', 'descricuadrilla', $this->descricuadrilla])    
                ;

        return $dataProvider;
     }
    
     public function search_by_turno($params,$id)
    {
        $query = VwCuadrillas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere(['turno_id'=>$id]);
        
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

      

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'codigotra', $this->codigotra])
            ->andFilterWhere(['like', 'codcuadrilla', $this->codcuadrilla])
            ->andFilterWhere(['like', 'descricuadrilla', $this->descricuadrilla])    
                ;

        return $dataProvider;
     }
     
     
    }
    
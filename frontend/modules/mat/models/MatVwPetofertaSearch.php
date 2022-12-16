<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatVwPetoferta;

class MatVwPetofertaSearch extends MatVwPetoferta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['id','idedetalle', 'codart', 'codum', 'codmon','codart','descripcion','fecha1','fecha',
                'pventa','punit','igv','despro','codpro'], 'safe'],
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
        $query = MatVwPetoferta::find();

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
         ->andFilterWhere(['like', 'despro', $this->despro])
        ->andFilterWhere(['codmon'=>$this->codmon])
       ->andFilterWhere(['codpro'=>$this->codpro])
           // ->andFilterWhere(['like', 'fechasol', $this->fechasol])
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])                  
                ;
        
         if(!empty($this->fecha) && !empty($this->fecha1)){
         $query->andFilterWhere([
             'between',
             'fecha',
             $this->openBorder('fecha',false),
             $this->openBorder('fecha1',true)
                        ]);   
        }
        
         if(!empty($this->pventa) && !empty($this->pventa1)){
         $query->andFilterWhere([
             'between',
             'pventa',
             $this->openBorder('pventa',false),
             $this->openBorder('pventa1',true)
                        ]);   
        }
        //echo  $query->createCommand()->rawSql;DIE();
        return $dataProvider;
    }
    
    public function search_by_os($id_os,$params){
         $query = MatVwReq::find();

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
        $query->andWhere(['os_id'=>$id_os]);
        $query->andWhere(['tipo'=> MatDetreq::TIPO_MATERIALE]);
        $query->andFilterWhere(['like', 'codart', $this->codart])
        ->andFilterWhere(['detos_id'=> $this->detos_id])
        ->andFilterWhere(['like', 'descridetalle', explode('%',$this->descridetalle)])
            //->andFilterWhere(['like', 'fechaprog', $this->fechaprog])
           // ->andFilterWhere(['like', 'fechasol', $this->fechasol])
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])                  
                ;
        
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

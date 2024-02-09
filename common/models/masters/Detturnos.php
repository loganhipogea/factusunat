<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%detturnos}}".
 *
 * @property int $id
 * @property string|null $codarea_id
 * @property int|null $turno_id
 * @property int|null $dia
 * @property string|null $activo
 * @property string|null $hi
 * @property string|null $hf
 * @property float|null $horas
 */
class Detturnos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
   public $booleanFields=['activo'];
   public $dateorTimeFields=[
       'hi'=>self::_FHOUR,
       'hf'=>self::_FHOUR,
       
   ];
    public static function tableName()
    {
        return '{{%detturnos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['turno_id', 'dia'], 'integer'],
            [['horas'], 'number'],
             [['activo'], 'safe'],
            [['codarea_id'], 'string', 'max' => 4],
            //[['activo'], 'string', 'max' => 1],
            [['hi', 'hf'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codarea_id' => Yii::t('app', 'Codarea ID'),
            'turno_id' => Yii::t('app', 'Turno ID'),
            'dia' => Yii::t('app', 'Dia'),
            'activo' => Yii::t('app', 'Activo'),
            'hi' => Yii::t('app', 'Hi'),
            'hf' => Yii::t('app', 'Hf'),
            'horas' => Yii::t('app', 'Horas'),
        ];
    }

    public function getTurno(){
        return $this->hasOne(Turnos::class, ['id'=>'turno_id']);
    }
    
    private function horas(){
        $hiCarbon=$this->toCarbon('hi');
        $hfCarbon=$this->toCarbon('hf');
        if($hiCarbon->lt($hfCarbon)){
           return $hfCarbon->floatDiffInHours($hiCarbon);
        }else{
           return $hiCarbon->floatDiffInHours($hfCarbon); 
        }
    }
    
    
    /**
     * {@inheritdoc}
     * @return DetturnosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DetturnosQuery(get_called_class());
    }
    
    
    public function beforeSave($insert) {
        $this->horas=$this->horas();
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        $this->turno->setHorasSemana()->save();//Sincronizando
        return parent::afterSave($insert, $changedAttributes);
    }
}

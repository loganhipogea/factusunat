<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "{{%resef_partedet}}".
 *
 * @property int $id
 * @property int|null $parte_id
 * @property int|null $orden_id
 * @property int|null $area_id
 * @property string|null $hinicio
 * @property string|null $hfin
 * @property string|null $actividad
 */


class ResefParteDet extends \common\models\base\modelBase
{
    const SCE_NORMAL='normal';
    
     public $dateorTimeFields = [
        'hinicio' => self::_FHOUR,
        'hfin' => self::_FHOUR,
        //'ftermino' => self::_FDATETIME
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%resef_partedet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parte_id', 'orden_id', 'area_id'], 'integer'],            
            [['orden_id', 'area_id','hinicio','hfin','actividad'], 'required','on'=>self::SCE_NORMAL],
            [['hinicio', 'hfin'], 'string', 'max' => 5],
             [['actividad'], 'safe'],   
            [['actividad'], 'string', 'max' => 60],
        ];
    }
 public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_NORMAL] = ['orden_id', 'area_id','hinicio','hfin','actividad'];
			       
       return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parte_id' => Yii::t('app', 'Parte ID'),
            'orden_id' => Yii::t('app', 'Orden ID'),
            'area_id' => Yii::t('app', 'Area ID'),
            'hinicio' => Yii::t('app', 'Hinicio'),
            'hfin' => Yii::t('app', 'Hfin'),
            'actividad' => Yii::t('app', 'Actividad'),
        ];
    }

    
    
    public function getArea()
    {
        return $this->hasOne(ResefAreas::className(), ['id' => 'area_id']);
    }
    /**
     * {@inheritdoc}
     * @return ResefPartesDetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResefPartesDetQuery(get_called_class());
    }
    
    public function verify_horas($attribute, $params){
        if($this->toCarbon('hinicio')->lt($this->toCarbon('hfin'))){
            $this->addError('hinicio',yii::t('base.errors','La hora de incio es menor que la hora de finalización'));
        }
        
    }
    
   public function nombreArea(){
       if(empty($this->area_id))return null;
       return $this->area->nombre;
   } 
    
}

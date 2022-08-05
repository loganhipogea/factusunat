<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "{{%op_tareosemana}}".
 *
 * @property int $id
 * @property string $codtra
 * @property int $proc_id
 * @property int $semana
 * @property float|null $he
 * @property float|null $h
 * @property float|null $hd
 * @property float|null $hf
 * @property float|null $hn
 * @property float|null $basicodiario
 * @property float|null $basico
 * @property float|null $dominical
 * @property float|null $extras MONTO SEMANAL POR HORAS EXTRAS Y FERIADOS 
 * @property float|null $total
 *
 * @property Trabajadores $codtra0
 * @property OpProcesos $proc
 */
class OpTareosemana extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_tareosemana}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtra', 'proc_id', 'semana'], 'required'],
            [['proc_id', 'semana'], 'integer'],
            [['he', 'h', 'hd', 'hf', 'hn', 'basicodiario', 'basico', 'dominical', 'extras', 'total'], 'number'],
            [['codtra'], 'string', 'max' => 6],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
            [['proc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpProcesos::className(), 'targetAttribute' => ['proc_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codtra' => Yii::t('base.names', 'Codtra'),
            'proc_id' => Yii::t('base.names', 'Proc ID'),
            'semana' => Yii::t('base.names', 'Semana'),
            'he' => Yii::t('base.names', 'He'),
            'h' => Yii::t('base.names', 'H'),
            'hd' => Yii::t('base.names', 'Hd'),
            'hf' => Yii::t('base.names', 'Hf'),
            'hn' => Yii::t('base.names', 'Hn'),
            'basicodiario' => Yii::t('base.names', 'Basicodiario'),
            'basico' => Yii::t('base.names', 'Basico'),
            'dominical' => Yii::t('base.names', 'Dominical'),
            'extras' => Yii::t('base.names', 'Extras'),
            'total' => Yii::t('base.names', 'Total'),
        ];
    }

    /**
     * Gets query for [[Codtra0]].
     *
     * @return \yii\db\ActiveQuery|TrabajadoresQuery
     */
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * Gets query for [[Proc]].
     *
     * @return \yii\db\ActiveQuery|OpProcesosQuery
     */
    public function getProc()
    {
        return $this->hasOne(OpProcesos::className(), ['id' => 'proc_id']);
    }

    /**
     * {@inheritdoc}
     * @return OpTareosemanaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpTareosemanaQuery(get_called_class());
    }
    
    private function array_where(){
        return [
        'proc_id'=>$this->proc_id,
        'semana'=>$this->semana,
        'codtra'=>$this->codtra,
        //'esferiado'=>($esferiado)?'1':'0',
            ];
    }
  
    private function queryCons($esFestivo){
       return (new \yii\db\Query())   
    ->from(OpTareodet::tableName())->andWhere($this->array_where($esFestivo)); 
    }
    
    
    public function refreshValues($modelJornada){
       $jornadas=$modelJornada::find()->andWhere([$this->array_where()])->all();
       foreach($jornadas as $jornada){
           
       }
       
       
      $valoresNormales=$this->queryCons(false)
     ->select(['sum(hextras) as he','sum(htotales)-sum(hextras) as h'])
     ->all();
      
       $valoresFestivos= $this->queryCons(false)
    ->select(['sum(htotales) as hf'])
    ->all();
       $this->setAttributes([
           'he'=>$valoresNormales['he'],
           'h'=>$valoresNormales['h'],
           'hf'=>$valoresFestivos['hf'],
           
       ]);
        
    }
}

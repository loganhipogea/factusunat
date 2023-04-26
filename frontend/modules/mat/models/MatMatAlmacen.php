<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_mat_almacen}}".
 *
 * @property int $id
 * @property string|null $codart
 * @property string|null $codal
 * @property float|null $ceconomica
 * @property float|null $creorden
 * @property float|null $crepo
 * @property int|null $leadtime
 */
class MatMatAlmacen extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_mat_almacen}}';
    }

    
    public function getAlmacen()
    {
        return $this->hasOne(\common\models\masters\Almacenes::className(), ['codal' => 'codal']);
    }
    
     public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['codart' => 'codart']);
    }
    
    
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ceconomica', 'creorden', 'crepo'], 'number'],
            //[['ceconomica', 'creorden', 'crepo'], 'validate_cantidades'],
            [['codal', 'codart'], 'unique', 'targetAttribute' => ['codal', 'codart']],
           
            [['leadtime'], 'integer'],
            [['codart'], 'string', 'max' => 14],
            [['codal'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codart' => Yii::t('base.names', 'Codart'),
            'codal' => Yii::t('base.names', 'Codal'),
            'ceconomica' => Yii::t('base.names', 'Ceconomica'),
            'creorden' => Yii::t('base.names', 'Creorden'),
            'crepo' => Yii::t('base.names', 'Crepo'),
            'leadtime' => Yii::t('base.names', 'Leadtime'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatMatAlmacenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatMatAlmacenQuery(get_called_class());
    }
    
    
    public function validate_cantidades($attribute,$params){
       if(!($this->ceconomica > $this->creorden 
               && $this->creorden>$this->crepo
               ))
        $this->adderror($this->ceconomica,yii::t('base.errors','La cantidades no son consistentes, por favor revise'));
         $this->adderror($this->creorden,yii::t('base.errors','La cantidades no son consistentes, por favor revise'));
     $this->adderror($this->crepo,yii::t('base.errors','La cantidades no son consistentes, por favor revise'));
    
       
    }
    
    private function modelStock(){
       return MatStock::findOne(['codal'=>$this->codart,'codart'=>$this->codart]);
       
    }
    
    public function beforeSave($insert) {
        if($insert){
            /*
             * Activando el semaforo del stock
             */
            
           if(!is_null($stock=$this->modelStock())){$stock->semaforo='R';$stock->save();}
        }
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        
        return parent::afterSave($insert, $changedAttributes);
    }
}

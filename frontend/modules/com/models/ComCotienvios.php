<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "com_cotienvios".
 *
 * @property int $id
 * @property int|null $version_id
 * @property int|null $coti_id
 * @property string|null $canal
 * @property string|null $exito
 * @property string|null $destinatarios
 */
class ComCotienvios extends \common\models\base\BaseDocument
{
   
   public $nameFieldEstado='exito'; 
   //public $estado=self::ST_CANCELED;
   public $dateorTimeFields = [
        'cuando' => self::_FDATETIME,
        
    ];
   
   
  
  
  
  public function isPassed(){
      return('OK'===$this->{$this->nameFieldEstado});
  }
    public function isRemoved(){
      return !('OK'===$this->{$this->nameFieldEstado});
  }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'com_cotienvios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['version_id', 'coti_id'], 'integer'],
             [['cuando'], 'safe'],
            [['destinatarios'], 'string'],
            [['canal'], 'string', 'max' => 5],
            [['exito'], 'string', 'max' => 19],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'version_id' => Yii::t('base.names', 'Version ID'),
            'coti_id' => Yii::t('base.names', 'Coti ID'),
            'canal' => Yii::t('base.names', 'Canal'),
            'exito' => Yii::t('base.names', 'Exito'),
            'destinatarios' => Yii::t('base.names', 'Destinatarios'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ComCotienviosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotienviosQuery(get_called_class());
    }
}

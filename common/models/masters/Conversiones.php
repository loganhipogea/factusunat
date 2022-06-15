<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%conversiones}}".
 *
 * @property int $id
 * @property string $codum1
 * @property string $codum2
 * @property double $valor1
 * @property double $valor2
 * @property string $codart
 *
 * @property Ums $codum20
 * @property Maestrocompo $codart0
 * @property Ums $codum10
 */
class Conversiones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%conversiones}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codum', 'valor1',], 'required'],
            [['valor1'], 'number'],
            [['codum', ], 'string', 'max' => 4],
            [['codart'], 'string', 'max' => 14],
            [['codart', 'codum'], 'unique', 'targetAttribute' => ['codart', 'codum']],
             [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
            [['codum'], 'exist', 'skipOnError' => true, 'targetClass' => Ums::className(), 'targetAttribute' => ['codum' => 'codum']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            
            'valor1' => Yii::t('base.names', 'Valor1'),
           
            'codart' => Yii::t('base.names', 'Codart'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
  

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   

    /**
     * {@inheritdoc}
     * @return ConversionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConversionesQuery(get_called_class());
    }
}

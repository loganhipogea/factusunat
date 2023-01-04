<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_activoscecos}}".
 *
 * @property int $id
 * @property int|null $activo_id
 * @property int|null $ceco_id
 * @property string|null $codmon
 * @property float|null $valor
 */
class MatActivoscecos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_activoscecos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activo_id', 'ceco_id'], 'integer'],
            [['valor'], 'number'],
            [['codmon'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activo_id' => Yii::t('app', 'Activo ID'),
            'ceco_id' => Yii::t('app', 'Ceco ID'),
            'codmon' => Yii::t('app', 'Codmon'),
            'valor' => Yii::t('app', 'Valor/Hora'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatActivoscecosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatActivoscecosQuery(get_called_class());
    }
    
     public function getCc()
    {
        return $this->hasOne(\frontend\modules\cc\models\CcCc::className(), ['id' => 'ceco_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivo()
    {
        return $this->hasOne(MatActivos::className(), ['id' => 'activo_id']);
    }
    
    
    

}

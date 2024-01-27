<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "mat_estructuracompo".
 *
 * @property int $id
 * @property int|null $maestro_id
 * @property string|null $codart
 * @property string|null $descri
 * @property string|null $item
 */
class MatEstructuracompo extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mat_estructuracompo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['maestro_id'], 'integer'],
            [['codart'], 'string', 'max' => 14],
            [['descri'], 'string', 'max' => 50],
            [['item'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'maestro_id' => Yii::t('app', 'Maestro ID'),
            'codart' => Yii::t('app', 'Codart'),
            'descri' => Yii::t('app', 'Descri'),
            'item' => Yii::t('app', 'Item'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatEstructuracompoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatEstructuracompoQuery(get_called_class());
    }
    
    
    public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['id' => 'maestro_id']);
    }
}

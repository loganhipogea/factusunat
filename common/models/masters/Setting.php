<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property int $id
 * @property string $type
 * @property string $section
 * @property string $key
 * @property string $value
 * @property int $status
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 */
class Setting extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'section', 'key', 'value', 'created_at', 'updated_at'], 'required'],
            [['value'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 10],
            [['section', 'key', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'type' => Yii::t('base.names', 'Type'),
            'section' => Yii::t('base.names', 'Section'),
            'key' => Yii::t('base.names', 'Key'),
            'value' => Yii::t('base.names', 'Value'),
            'status' => Yii::t('base.names', 'Status'),
            'description' => Yii::t('base.names', 'Description'),
            'created_at' => Yii::t('base.names', 'Created At'),
            'updated_at' => Yii::t('base.names', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingQuery(get_called_class());
    }
}

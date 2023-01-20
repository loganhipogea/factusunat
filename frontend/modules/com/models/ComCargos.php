<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "{{%com_cargos}}".
 *
 * @property int $id
 * @property string|null $descripcion
 * @property float|null $porcentaje
 * @property string|null $detalle
 *
 * @property ComCargoscoti[] $comCargoscotis
 */
class ComCargos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_cargos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['porcentaje'], 'number'],
            [['detalle'], 'string'],
            [['descripcion'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'porcentaje' => Yii::t('app', 'Porcentaje'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * Gets query for [[ComCargoscotis]].
     *
     * @return \yii\db\ActiveQuery|ComCargoscotiQuery
     */
    public function getComCargoscotis()
    {
        return $this->hasMany(ComCargoscoti::className(), ['cargo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ComCargosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCargosQuery(get_called_class());
    }
}

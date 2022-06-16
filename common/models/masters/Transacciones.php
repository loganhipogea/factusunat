<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "transacciones".
 *
 * @property string $codtrans
 * @property string $descripcion
 * @property int $signo
 * @property string|null $detalles
 *
 * @property Transadocs[] $transadocs
 */
class Transacciones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transacciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtrans', 'descripcion', 'signo'], 'required'],
            [['signo'], 'integer'],
            [['detalles'], 'string'],
            [['codtrans'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['codtrans'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codtrans' => Yii::t('base.names', 'Codtrans'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'signo' => Yii::t('base.names', 'Signo'),
            'detalles' => Yii::t('base.names', 'Detalles'),
        ];
    }

    /**
     * Gets query for [[Transadocs]].
     *
     * @return \yii\db\ActiveQuery|TransadocsQuery
     */
    public function getTransadocs()
    {
        return $this->hasMany(Transadocs::className(), ['codtrans' => 'codtrans']);
    }

    /**
     * {@inheritdoc}
     * @return TransaccionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransaccionesQuery(get_called_class());
    }
}

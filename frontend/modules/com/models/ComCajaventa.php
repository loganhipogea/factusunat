<?php

namespace frontend\modules\com\models;
USE common\models\masters\Centros;
use Yii;

/**
 * This is the model class for table "{{%com_cajaventa}}".
 *
 * @property int $id
 * @property string|null $codcaja
 * @property string|null $nombre
 * @property string|null $codcen
 * @property string|null $codsoc
 * @property string|null $path_impresora
 * @property int|null $user_id
 *
 * @property Centros $codcen0
 */
class ComCajaventa extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_cajaventa}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['codcaja', 'codcen'], 'string', 'max' => 4],
            [['nombre'], 'string', 'max' => 12],
            [['codsoc'], 'string', 'max' => 1],
            [['path_impresora'], 'string', 'max' => 100],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codcaja' => Yii::t('base.names', 'Codcaja'),
            'nombre' => Yii::t('base.names', 'Nombre'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'path_impresora' => Yii::t('base.names', 'Path Impresora'),
            'user_id' => Yii::t('base.names', 'User ID'),
        ];
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|CentrosQuery
     */
    public function getCodcen0()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    /**
     * {@inheritdoc}
     * @return ComCajaventaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCajaventaQuery(get_called_class());
    }
}

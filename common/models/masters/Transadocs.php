<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "transadocs".
 *
 * @property int $id
 * @property string $codtrans
 * @property string $codocu
 * @property string $tipodoc
 * @property string $codestado
 *
 * @property Documentos $codocu0
 * @property Transacciones $codtrans0
 */
class Transadocs extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transadocs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtrans', 'codocu', 'tipodoc', 'codestado'], 'required'],
            [['codtrans', 'codocu'], 'string', 'max' => 3],
            [['tipodoc', 'codestado'], 'string', 'max' => 2],
            [['codocu'], 'exist', 'skipOnError' => true, 'targetClass' => Documentos::className(), 'targetAttribute' => ['codocu' => 'codocu']],
            [['codtrans'], 'exist', 'skipOnError' => true, 'targetClass' => Transacciones::className(), 'targetAttribute' => ['codtrans' => 'codtrans']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codtrans' => Yii::t('base.names', 'Codtrans'),
            'codocu' => Yii::t('base.names', 'Codocu'),
            'tipodoc' => Yii::t('base.names', 'Tipodoc'),
            'codestado' => Yii::t('base.names', 'Codestado'),
        ];
    }

    /**
     * Gets query for [[Codocu0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getDocu()
    {
        return $this->hasOne(Documentos::className(), ['codocu' => 'codocu']);
    }

    /**
     * Gets query for [[Codtrans0]].
     *
     * @return \yii\db\ActiveQuery|TransaccionesQuery
     */
    public function getCodtrans0()
    {
        return $this->hasOne(Transacciones::className(), ['codtrans' => 'codtrans']);
    }

    /**
     * {@inheritdoc}
     * @return TransadocsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransadocsQuery(get_called_class());
    }
}

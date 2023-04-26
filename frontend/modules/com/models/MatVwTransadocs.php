<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "{{%mat_vw_transadocs}}".
 *
 * @property string $codtrans
 * @property string $descripcion
 * @property int $signo
 * @property string|null $detalles
 * @property int $id
 * @property string $tipodoc
 * @property string $codestado
 * @property string $codocu
 * @property string $desdocu
 * @property string|null $modelo
 */
class MatVwTransadocs extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_vw_transadocs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtrans', 'descripcion', 'signo', 'tipodoc', 'codestado', 'codocu', 'desdocu'], 'required'],
            [['signo', 'id'], 'integer'],
            [['detalles'], 'string'],
            [['codtrans', 'codocu'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['tipodoc', 'codestado'], 'string', 'max' => 2],
            [['desdocu'], 'string', 'max' => 60],
            [['modelo'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codtrans' => Yii::t('base', 'Codtrans'),
            'descripcion' => Yii::t('base', 'Descripcion'),
            'signo' => Yii::t('base', 'Signo'),
            'detalles' => Yii::t('base', 'Detalles'),
            'id' => Yii::t('base', 'ID'),
            'tipodoc' => Yii::t('base', 'Tipodoc'),
            'codestado' => Yii::t('base', 'Codestado'),
            'codocu' => Yii::t('base', 'Codocu'),
            'desdocu' => Yii::t('base', 'Desdocu'),
            'modelo' => Yii::t('base', 'Modelo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatVwTransadocsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatVwTransadocsQuery(get_called_class());
    }
}

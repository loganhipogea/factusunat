<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "{{%op_vw_trabataller}}".
 *
 * @property int $id
 * @property string $codigotra
 * @property string $ap
 * @property string $am
 * @property string $nombres
 * @property string|null $dni
 * @property string|null $ppt
 * @property string|null $pasaporte
 * @property string $codpuesto
 * @property string $cumple
 * @property string|null $fecingreso
 * @property string|null $domicilio
 * @property string|null $telfijo
 * @property string|null $telmoviles
 * @property string|null $referencia
 * @property string|null $nombrearea
 * @property string|null $codtra
 * @property int|null $area_id
 */
class OpVwTrabataller extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_vw_trabataller}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'area_id'], 'integer'],
            [['codigotra', 'ap', 'am', 'nombres', 'codpuesto', 'cumple'], 'required'],
            [['codigotra', 'codtra'], 'string', 'max' => 6],
            [['ap', 'am', 'nombres'], 'string', 'max' => 40],
            [['dni'], 'string', 'max' => 12],
            [['ppt', 'pasaporte', 'cumple', 'fecingreso'], 'string', 'max' => 10],
            [['codpuesto'], 'string', 'max' => 3],
            [['domicilio'], 'string', 'max' => 73],
            [['telfijo'], 'string', 'max' => 13],
            [['telmoviles', 'referencia'], 'string', 'max' => 30],
            [['nombrearea'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigotra' => Yii::t('app', 'Codigotra'),
            'ap' => Yii::t('app', 'Ap'),
            'am' => Yii::t('app', 'Am'),
            'nombres' => Yii::t('app', 'Nombres'),
            'dni' => Yii::t('app', 'Dni'),
            'ppt' => Yii::t('app', 'Ppt'),
            'pasaporte' => Yii::t('app', 'Pasaporte'),
            'codpuesto' => Yii::t('app', 'Codpuesto'),
            'cumple' => Yii::t('app', 'Cumple'),
            'fecingreso' => Yii::t('app', 'Fecingreso'),
            'domicilio' => Yii::t('app', 'Domicilio'),
            'telfijo' => Yii::t('app', 'Telfijo'),
            'telmoviles' => Yii::t('app', 'Telmoviles'),
            'referencia' => Yii::t('app', 'Referencia'),
            'nombrearea' => Yii::t('app', 'Nombrearea'),
            'codtra' => Yii::t('app', 'Codtra'),
            'area_id' => Yii::t('app', 'Area ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return OpVwTrabatallerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpVwTrabatallerQuery(get_called_class());
    }
}

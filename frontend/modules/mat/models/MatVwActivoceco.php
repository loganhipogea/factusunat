<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_vw_activoceco}}".
 *
 * @property string|null $codmon
 * @property float|null $valor
 * @property int $idactivo
 * @property string|null $codactivo
 * @property string|null $descripcion
 * @property string|null $marca
 * @property string|null $modelo
 * @property string|null $serie
 * @property float|null $v_adquisicion
 * @property int|null $vida_util
 * @property float|null $v_rescate
 * @property int $idceco
 * @property string|null $codceco
 * @property string|null $descriceco
 */
class MatVwActivoceco extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_vw_activoceco}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor', 'v_adquisicion', 'v_rescate'], 'number'],
            [['idactivo', 'vida_util', 'idceco'], 'integer'],
            [['codmon'], 'string', 'max' => 5],
            [['codactivo', 'codceco'], 'string', 'max' => 10],
            [['descripcion', 'marca', 'modelo', 'serie', 'descriceco'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codmon' => Yii::t('app', 'Codmon'),
            'valor' => Yii::t('app', 'Valor-Hora'),
            'idactivo' => Yii::t('app', 'Idactivo'),
            'codactivo' => Yii::t('app', 'Codactivo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'marca' => Yii::t('app', 'Marca'),
            'modelo' => Yii::t('app', 'Modelo'),
            'serie' => Yii::t('app', 'Serie'),
            'v_adquisicion' => Yii::t('app', 'V Adquisicion'),
            'vida_util' => Yii::t('app', 'Vida Util'),
            'v_rescate' => Yii::t('app', 'V Rescate'),
            'idceco' => Yii::t('app', 'Idceco'),
            'codceco' => Yii::t('app', 'Codceco'),
            'descriceco' => Yii::t('app', 'Descriceco'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatVwActivocecoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatVwActivocecoQuery(get_called_class());
    }
}

<?php

namespace frontend\modules\logi\models;

use Yii;

/**
 * This is the model class for table "{{%logi_vw_stock}}".
 *
 * @property int $id
 * @property string $codart
 * @property string $codcen
 * @property string|null $codal
 * @property string|null $um
 * @property float|null $cant
 * @property string|null $ubicacion
 * @property float|null $valor
 * @property float|null $pventa
 * @property string $descripcion
 * @property string|null $marca
 * @property string|null $modelo
 */
class LogiVwStock extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%logi_vw_stock}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codart', 'codcen', 'descripcion'], 'required'],
            [['cant', 'valor', 'pventa'], 'number'],
            [['codart'], 'string', 'max' => 14],
            [['codcen', 'codal', 'um'], 'string', 'max' => 4],
            [['ubicacion'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 60],
            [['marca', 'modelo'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codart' => Yii::t('base.names', 'Codart'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'codal' => Yii::t('base.names', 'Codal'),
            'um' => Yii::t('base.names', 'Um'),
            'cant' => Yii::t('base.names', 'Cant'),
            'ubicacion' => Yii::t('base.names', 'Ubicacion'),
            'valor' => Yii::t('base.names', 'Valor'),
            'pventa' => Yii::t('base.names', 'Pventa'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'marca' => Yii::t('base.names', 'Marca'),
            'modelo' => Yii::t('base.names', 'Modelo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return LogiVwStockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogiVwStockQuery(get_called_class());
    }
}

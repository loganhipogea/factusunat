<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%vw_sucursales}}".
 *
 * @property string $codcen
 * @property string $nomcen
 * @property string $codpro
 * @property string|null $codsoc
 */
class VwSucursales extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sucursales}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codcen', 'nomcen', 'codpro'], 'required'],
            [['codcen'], 'string', 'max' => 5],
            [['nomcen'], 'string', 'max' => 60],
            [['codpro'], 'string', 'max' => 6],
            [['codsoc'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codcen' => Yii::t('base.names', 'Codcen'),
            'nomcen' => Yii::t('base.names', 'Nomcen'),
            'codpro' => Yii::t('base.names', 'Codpro'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwSucursalesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwSucursalesQuery(get_called_class());
    }
}

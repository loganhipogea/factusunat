<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "almacenes".
 *
 * @property string $codal
 * @property string $nomal
 * @property string $tipo
 * @property string $codcen
 * @property string $tipoval tipo valorizacion : promedio, LIFO FIFO
 * @property string $reposicionsololibre solo tomar encuenta el stock libre , no el reservado ni el de transito
 * @property string|null $estructura
 * @property string $novalorado
 * @property float|null $tolstockres Toleracia de merma
 * @property string $codmon
 * @property string $agregarauto
 * @property string $bloqueado
 *
 * @property Centros $codcen0
 */
class Almacenes extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public $booleanFields=[
        'reposicionsololibre', 'novalorado',
        'agregarauto', 'bloqueado'
        ];
    public static function tableName()
    {
        return 'almacenes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codal', 'nomal', 'tipo', 'codcen', 'codmon',], 'required'],
            [['tolstockres'], 'number'],
            [['codal'], 'string', 'max' => 4],
            [['nomal'], 'string', 'max' => 25],
            [['tipo'], 'string', 'max' => 2],
            [['codcen'], 'string', 'max' => 5],
            [['tipoval'], 'string', 'max' => 1],
            [['estructura'], 'string', 'max' => 15],
            [['codmon'], 'string', 'max' => 3],
            [['codal'], 'unique'],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codal' => Yii::t('base.names', 'Codal'),
            'nomal' => Yii::t('base.names', 'Nomal'),
            'tipo' => Yii::t('base.names', 'Tipo'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'tipoval' => Yii::t('base.names', 'Tipoval'),
            'reposicionsololibre' => Yii::t('base.names', 'Reposicionsololibre'),
            'estructura' => Yii::t('base.names', 'Estructura'),
            'novalorado' => Yii::t('base.names', 'Novalorado'),
            'tolstockres' => Yii::t('base.names', 'Tolstockres'),
            'codmon' => Yii::t('base.names', 'Codmon'),
            'agregarauto' => Yii::t('base.names', 'Agregarauto'),
            'bloqueado' => Yii::t('base.names', 'Bloqueado'),
        ];
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCodcen0()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    /**
     * {@inheritdoc}
     * @return AlmacenesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlmacenesQuery(get_called_class());
    }
}

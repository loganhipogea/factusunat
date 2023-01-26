<?php

namespace frontend\modules\coti\models;

use Yii;

/**
 * This is the model class for table "{{%com_cotiversiones}}".
 *
 * @property int $id
 * @property int|null $coti_id
 * @property float|null $numero
 * @property string|null $cuando
 * @property string|null $detalles
 */
class ComCotiversiones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_cotiversiones}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coti_id'], 'integer'],
            [['numero'], 'number'],
            [['detalles'], 'string'],
            [['cuando'], 'string', 'max' => 19],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'coti_id' => Yii::t('app', 'Coti ID'),
            'numero' => Yii::t('app', 'Numero'),
            'cuando' => Yii::t('app', 'Cuando'),
            'detalles' => Yii::t('app', 'Detalles'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \frontend\modules\com\models\ComCotiversionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\modules\com\models\ComCotiversionesQuery(get_called_class());
    }
}

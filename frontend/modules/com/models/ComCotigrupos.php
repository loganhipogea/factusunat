<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "com_cotigrupos".
 *
 * @property int $id
 * @property string|null $descripartida
 * @property string|null $calificacion
 * @property float|null $total
 * @property string|null $item
 * @property int|null $coti_id
 */
class ComCotigrupos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'com_cotigrupos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total'], 'number'],
            [['coti_id'], 'integer'],
            [['descripartida'], 'string', 'max' => 40],
            [['calificacion'], 'string', 'max' => 1],
            [['item'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descripartida' => Yii::t('app', 'Descripartida'),
            'calificacion' => Yii::t('app', 'Calificacion'),
            'total' => Yii::t('app', 'Total'),
            'item' => Yii::t('app', 'Item'),
            'coti_id' => Yii::t('app', 'Coti ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ComCotigruposQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotigruposQuery(get_called_class());
    }
    
     public function getCoti() {
        return $this->hasMany(ComCotizacion::className(), ['id' => 'coti_id']);
    }
}

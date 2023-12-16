<?php

namespace frontend\modules\op\models;

use Yii;
use common\models\masters\Trabajadores;
/**
 * This is the model class for table "{{%resef_trabataller}}".
 *
 * @property int $id
 * @property string|null $codtra
 * @property int|null $area_id
 */
class ResefTrabataller extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%resef_trabataller}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['area_id'], 'integer'],
            [['codtra'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codtra' => Yii::t('app', 'Codtra'),
            'area_id' => Yii::t('app', 'Area ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ResefTrabatallerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResefTrabatallerQuery(get_called_class());
    }
    
    
     public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function getArea()
    {
        return $this->hasOne(ResefAreas::className(), ['id' => 'area_id']);
    }
    
    
}

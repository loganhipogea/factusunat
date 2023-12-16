<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "subfamilia".
 *
 * @property string $codsubfam
 * @property string|null $codfam
 * @property string|null $descrisubfam
 */
class SubFamilia extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subfamilia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codsubfam'], 'required'],
            
            [['familia_id'], 'safe'],
            [['codsubfam', 'codfam'], 'string', 'max' => 2],
            [['descrisubfam'], 'string', 'max' => 50],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codsubfam' => Yii::t('app', 'Codsubfam'),
            'codfam' => Yii::t('app', 'Codfam'),
            'descrisubfam' => Yii::t('app', 'Descrisubfam'),
        ];
    }
    
     public function getFamilia()
    {
        return $this->hasOne(Familia::className(), ['id' => 'familia_id']);
    }

    public function getSubSubFamilias()
    {
        return $this->hasMany(SubSubFamilia::className(), ['subfamilia_id' => 'id']);
    }
    
    public function prefix(){
        return $this->codfam.'.'.$this->codsubfam.'-';
    }
}

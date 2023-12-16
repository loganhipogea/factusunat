<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "familia".
 *
 * @property string $codfam
 * @property string|null $descrifam
 */
class Familia extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'familia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codfam'], 'required'],
            
            [['codfam'], 'string', 'max' => 2],
            [['descrifam'], 'string', 'max' => 50],
            [['codfam'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codfam' => Yii::t('app', 'Codfam'),
            'descrifam' => Yii::t('app', 'Descrifam'),
        ];
    }
    
    
     public function prefix(){
        return $this->codfam.'-';
    }
}

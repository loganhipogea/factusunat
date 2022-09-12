<?php

namespace common\models\audit;

use Yii;

/**
 * This is the model class for table "{{%activerecordlog}}".
 *
 * @property string $id
 * @property string $model
 * @property string $field
 * @property string $ip
 * @property string $creationdate
 * @property string $controlador
 * @property string $description
 * @property string $nombrecampo
 * @property string $oldvalue
 * @property string $newvalue
 * @property string $username
 * @property string $metodo
 * @property string $action
 * @property string $clave
 */
class Activerecordlog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activerecordlog}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clave'], 'string'],
            [[ 'field', 'nombrecampo'], 'string', 'max' => 45],
             [[ 'model'], 'string', 'max' => 100],            
            [['ip', 'creationdate'], 'string', 'max' => 20],
            [['controlador'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 105],
            [['oldvalue', 'newvalue'], 'string', 'max' => 80],
            [['username'], 'string', 'max' => 30],
            [['metodo'], 'string', 'max' => 7],
            [['action'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'model' => Yii::t('base.names', 'Model'),
            'field' => Yii::t('base.names', 'Campo'),
            'ip' => Yii::t('base.names', 'IP'),
            'creationdate' => Yii::t('base.names', 'Cuándo'),
            'controlador' => Yii::t('base.names', 'Controlador'),
            'description' => Yii::t('base.names', 'Description'),
            'nombrecampo' => Yii::t('base.names', 'Campo'),
            'oldvalue' => Yii::t('base.names', 'Val.Previo'),
            'newvalue' => Yii::t('base.names', 'Val. Actual'),
            'username' => Yii::t('base.names', 'Usuario'),
            'metodo' => Yii::t('base.names', 'Metodo'),
            'action' => Yii::t('base.names', 'Action'),
            'clave' => Yii::t('base.names', 'Clave'),
        ];
    }
}

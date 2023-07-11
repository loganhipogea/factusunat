<?php

namespace frontend\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "{{%ait_menus}}".
 *
 * @property int $id
 * @property string|null $valor
 * @property int|null $parent_id
 * @property string|null $activo
 * @property string|null $clave
 * @property string|null $url
 * @property int|null $orden
 * @property string|null $tiene_hijos
 */
class AitMenus extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ait_menus}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor', 'url'], 'string'],
             [['activo'], 'safe'],
            [['parent_id', 'orden'], 'integer'],
            
            [['activo', 'tiene_hijos'], 'string', 'max' => 1],
            [['clave'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'valor' => Yii::t('base.names', 'Valor'),
            'parent_id' => Yii::t('base.names', 'Parent ID'),
            'activo' => Yii::t('base.names', 'Activo'),
            'clave' => Yii::t('base.names', 'Clave'),
            'url' => Yii::t('base.names', 'Url'),
            'orden' => Yii::t('base.names', 'Orden'),
            'tiene_hijos' => Yii::t('base.names', 'Tiene Hijos'),
        ];
    }

    
    public function getPadre() {
        if(!is_null($this->parent_id))
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
        return $this;
    }
    /**
     * {@inheritdoc}
     * @return AitMenusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AitMenusQuery(get_called_class());
    }
    
    
    public function contenidos(){
        return ArrayHelper::map(
                        AitContenidos::find()->andWhere(['zona'=>'ENLACE'])->all(),
                'id','titulo');
    }
    
    public function menusPadres(){
        $data= ArrayHelper::map(
                        AitMenus::find()/*
                         * ->andWhere(['not','parent_id > 0'])*/
                ->all(),
                'id','valor');
        unset($data[$this->id]);
        return $data;
    }
    
    public function beforeSave($insert) {
        
        return parent::beforeSave($insert);
    }
    
    
    
}

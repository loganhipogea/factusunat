<?php

namespace frontend\models;
use common\helpers\FileHelper;
use common\behaviors\FileBehavior;
use yii\helpers\Json;
use Yii;

/**
 * This is the model class for table "{{%ait_contenidos}}".
 *
 * @property int $id
 * @property int|null $menu_id
 * @property string|null $clave
 * @property string|null $titulo
 * @property string|null $activo
 * @property string|null $cuerpo
 * @property int|null $orden
 * @property string|null $zona
 * @property string|null $url
 */
class AitContenidos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ait_contenidos}}';
    }

    
     public function behaviors() {
        return [
           
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
           
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id', 'orden'], 'integer'],
            [['adjuntos','activo'], 'safe'],
            [['clave', 'titulo', 'cuerpo'], 'string'],
            [['activo'], 'string', 'max' => 1],
            [['zona'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 200],
        ];
    }

    
     public function getColumnas() {
        return $this->hasMany(AitColumnas::className(), ['contenido_id' => 'id']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'menu_id' => Yii::t('base.names', 'Menu ID'),
            'clave' => Yii::t('base.names', 'Clave'),
            'titulo' => Yii::t('base.names', 'Titulo'),
            'activo' => Yii::t('base.names', 'Activo'),
            'cuerpo' => Yii::t('base.names', 'Cuerpo'),
            'orden' => Yii::t('base.names', 'Orden'),
            'zona' => Yii::t('base.names', 'Zona'),
            'url' => Yii::t('base.names', 'Url'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AitContenidosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AitContenidosQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        
        if($insert){
            $this->zona='ENLACE';
             $this->activo=true;
        }
       
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        $adjuntos=[];
        
        
        foreach($this->files as $file){
            $adjuntos[]=$file->urlTempWeb;
        }
         $valor=Json::encode($adjuntos);
         AitContenidos::updateAll(['adjuntos'=>$valor],['id'=>$this->id]);
        return parent::afterSave($insert, $changedAttributes);
    }
}

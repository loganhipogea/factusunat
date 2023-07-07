<?php

namespace frontend\models;
use yii\helpers\ArrayHelper;
use common\behaviors\FileBehavior;
use Yii;

/**
 * This is the model class for table "{{%ait_columnas}}".
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $leyenda
 */
class AitColumnas extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ait_columnas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leyenda'], 'string'],
             [['contenido_id'], 'safe'],
            [['titulo'], 'string', 'max' => 100],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'titulo' => Yii::t('base.names', 'Titulo'),
            'leyenda' => Yii::t('base.names', 'Leyenda'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AitColumnasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AitColumnasQuery(get_called_class());
    }
    
    
    public function contenidosPadres(){
        $data= ArrayHelper::map(
                        AitContenidos::find()
                         ->andWhere(['ZONA'=>'ENLACE'])
                ->all(),
                'id','titulo');
        unset($data[$this->id]);
        return $data;
    }
    
    public function afterFind() {
        if($this->hasAttachments()){
            $this->ruta=$this->files[0]->urlTempWeb;
        }
        return parent::afterFind();
    }
    
}

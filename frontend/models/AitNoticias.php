<?php

namespace frontend\models;
use common\behaviors\FileBehavior;
use common\helpers\timeHelper;
use Yii;

/**
 * This is the model class for table "{{%ait_noticias}}".
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $contenido
 * @property string|null $fecha
 * @property string|null $fecha_cre
 */
class AitNoticias extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ait_noticias}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contenido'], 'string'],
            [['activo'], 'safe'],
            [['titulo'], 'string', 'max' => 50],
            [['fecha'], 'string', 'max' => 10],
            [['fecha_cre'], 'string', 'max' => 19],
        ];
    }
 public function behaviors() {
        return [
           
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
           
        ];
    }
    
 public $dateorTimeFields = [
        'fecha' => self::_FDATE,
        'fecha_cre' => self::_FDATETIME,     
    ];
 public $booleanFields = [
        'activo'   
    ];
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'titulo' => Yii::t('base.names', 'Titulo'),
            'contenido' => Yii::t('base.names', 'Contenido'),
            'fecha' => Yii::t('base.names', 'Fecha'),
            'fecha_cre' => Yii::t('base.names', 'Fecha Cre'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AitNoticiasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AitNoticiasQuery(get_called_class());
    }
    
    
    public function beforeSave($insert) {
        $this->fecha_cre=date(timeHelper::formatMysqlDateTime());
        return parent::beforeSave($insert);
    }
}

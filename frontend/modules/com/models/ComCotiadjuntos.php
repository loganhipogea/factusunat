<?php

namespace frontend\modules\com\models;
use common\behaviors\FileBehavior;
use Yii;

/**
 * This is the model class for table "com_cotiadjuntos".
 *
 * @property int $id
 * @property int|null $coti_id
 * @property string|null $descripcion
 * @property int|null $orden
 * @property string|null $detalle
 */
class ComCotiadjuntos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_cotiadjuntos}}';
    }

    public $booleanFields=['interno'];
     public function behaviors() {
        return [
           
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
            
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coti_id', 'orden'], 'integer'],
            [['detalle'], 'string'],
              [['interno'], 'safe'],
            [['descripcion'], 'string', 'max' => 40],
        ];
    }

    
    public function getCoti()
    {
        return $this->hasOne(ComCotizacion::className(), ['id' => 'coti_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'coti_id' => Yii::t('base.names', 'Coti ID'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'orden' => Yii::t('base.names', 'Orden'),
            'detalle' => Yii::t('base.names', 'Detalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ComCotiadjuntosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotiadjuntosQuery(get_called_class());
    }
}

<?php

namespace frontend\modules\com\models;
use common\models\masters\Contactos;
use Yii;

/**
 * This is the model class for table "com_contactocoti".
 *
 * @property int $id
 * @property int|null $coti_id
 * @property int|null $cotizacion_id
 * @property int|null $prioridad
 * @property string|null $send
 *
 * @property ComCotizaciones $coti
 * @property Contactos $coti0
 */
class ComContactocoti extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
    public $booleanFields=['send'];
    public static function tableName()
    {
        return '{{%com_contactocoti}}';
    }
     public function behaviors() {
        return [
           
           /* 'fileBehavior' => [
                'class' => FileBehavior::className()
            ],*/
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
            [['coti_id', 'coti_id', 'prioridad'], 'integer'],
            //[['send'], 'string', 'max' => 1],
            [['coti_id', 'contacto_id'], 'unique', 'targetAttribute' => ['coti_id', 'contacto_id']],
            [['coti_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComCotizacion::class, 'targetAttribute' => ['coti_id' => 'id']],
            [['coti_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contactos::class, 'targetAttribute' => ['contacto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'coti_id' => Yii::t('base.names', 'Coti ID'),
            'contacto_id' => Yii::t('base.names', 'Cotizacion ID'),
            'prioridad' => Yii::t('base.names', 'Prioridad'),
            'send' => Yii::t('base.names', 'Send'),
        ];
    }

    /**
     * Gets query for [[Coti]].
     *
     * @return \yii\db\ActiveQuery|ComCotizacionesQuery
     */
    public function getCoti()
    {
        return $this->hasOne(ComCotizacion::class, ['id' => 'coti_id']);
    }

    
    
    public function getClipro()
    {
        return $this->hasOne(\common\models\masters\Clipro::class, ['codpro' => 'codpro']);
    }

    /**
     * Gets query for [[Coti0]].
     *
     * @return \yii\db\ActiveQuery|ContactosQuery
     */
    public function getContacto()
    {
        return $this->hasOne(Contactos::class, ['id' => 'contacto_id']);
    }

    /**
     * {@inheritdoc}
     * @return ComContactocotiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComContactocotiQuery(get_called_class());
    }
}

<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%docutrabajadores}}".
 *
 * @property int $id
 * @property string|null $codocu
 * @property string|null $codtra
 * @property string $numero
 * @property string|null $fvence
 * @property string|null $descripcion
 * @property string|null $textointerno
 * @property int|null $user_id
 *
 * @property Trabajadores $codtra0
 */
class Docutrabajadores extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%docutrabajadores}}';
    }
    
    public function behaviors()
         {
                return [
		
		'fileBehavior' => [
			'class' => '\common\behaviors\FileBehavior' 
                               ],
                    
		
                    ];
        }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero'], 'required'],
            [['textointerno'], 'string'],
            [['user_id'], 'integer'],
            [['codocu'], 'string', 'max' => 3],
            [['codtra'], 'string', 'max' => 6],
            [['numero'], 'string', 'max' => 20],
            [['fvence'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 40],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codocu' => Yii::t('base.names', 'Codocu'),
            'codtra' => Yii::t('base.names', 'Codtra'),
            'numero' => Yii::t('base.names', 'Numero'),
            'fvence' => Yii::t('base.names', 'Fvence'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'textointerno' => Yii::t('base.names', 'Textointerno'),
            'user_id' => Yii::t('base.names', 'User ID'),
        ];
    }

    /**
     * Gets query for [[Codtra0]].
     *
     * @return \yii\db\ActiveQuery|TrabajadoresQuery
     */
    public function getTrabajadores()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function getDocumento()
    {
        return $this->hasOne(Documentos::className(), ['codocu' => 'codocu']);
    }

    /**
     * {@inheritdoc}
     * @return DocutrabajadoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocutrabajadoresQuery(get_called_class());
    }
}

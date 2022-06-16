<?php

namespace frontend\modules\import\models;

use Yii;

/**
 * This is the model class for table "{{%import_cargamasivadet}}".
 *
 * @property int $id
 * @property int $cargamasiva_id
 * @property string $nombrecampo
 * @property string $aliascampo
 * @property int $sizecampo
 * @property string $activa
 * @property string $requerida
 * @property string $tipo
 * @property string $esclave
 * @property string $detalle
 * @property string $esforeign
 * @property int $parent_id
 * @property string $modelo
 *
 * @property ImportCargamasiva $cargamasiva
 */
class ImportCargamasivadet extends \common\models\base\modelBase
{
   public $booleanFields=[
            'activa',
             'esclave',
            'requerida',
            'esforeign'
                    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%import_cargamasivadet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cargamasiva_id', 'nombrecampo', 'aliascampo', 'sizecampo'], 'required'],
            [['cargamasiva_id', 'sizecampo', 'parent_id'], 'integer'],
            [['detalle'], 'string'],
            [['nombrecampo', 'aliascampo', 'modelo'], 'string', 'max' => 60],
            [['activa', 'requerida', 'esclave','orden', 'esforeign'], 'safe'],
            [['tipo'], 'string', 'max' => 20],
            [['cargamasiva_id'], 'exist', 'skipOnError' => true, 'targetClass' => ImportCargamasiva::className(), 'targetAttribute' => ['cargamasiva_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('import.labels', 'ID'),
            'cargamasiva_id' => Yii::t('import.labels', 'Cargamasiva ID'),
            'nombrecampo' => Yii::t('import.labels', 'Campo'),
            'aliascampo' => Yii::t('import.labels', 'Alias'),
            'sizecampo' => Yii::t('import.labels', 'Ancho'),
            'activa' => Yii::t('import.labels', 'Activo'),
            'requerida' => Yii::t('import.labels', 'Oblig.'),
            'tipo' => Yii::t('import.labels', 'Tipo Dato'),
            'esclave' => Yii::t('import.labels', 'Clave'),
            'detalle' => Yii::t('import.labels', 'Detalle'),
            'esforeign' => Yii::t('import.labels', 'Relacionado'),
            'parent_id' => Yii::t('import.labels', 'Parent ID'),
            'modelo' => Yii::t('import.labels', 'Tabla'),
            'nveces' => Yii::t('import.labels', 'N repetic'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargamasiva()
    {
        return $this->hasOne(ImportCargamasiva::className(), ['id' => 'cargamasiva_id']);
    }

    /**
     * {@inheritdoc}
     * @return ImportCargamasivadetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImportCargamasivadetQuery(get_called_class());
    }
}

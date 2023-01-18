<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "{{%com_detcoti}}".
 *
 * @property int $id
 * @property int|null $coti_id
 * @property string|null $item
 * @property string|null $tipo tipo material o servicio
 * @property string|null $codart
 * @property string|null $descripcion
 * @property string|null $detalle
 * @property string|null $codum
 * @property float|null $cant
 * @property float|null $punit
 * @property float|null $ptotal
 * @property float|null $igv
 * @property float|null $pventa
 * @property float|null $punitcalculado
 * @property int|null $cotigrupo_id
 * @property int|null $coticeco_id
 * @property int|null $detcoti_id
 * @property int|null $detcoti_id_id
 * @property int|null $servicio_id
 * @property string|null $flag
 * @property string|null $codcargo
 * @property string|null $codactivo
 *
 * @property ComCotizaciones $coti
 */
class ComCotiDet extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_detcoti}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coti_id', 'cotigrupo_id', 'coticeco_id', 'detcoti_id', 'detcoti_id_id', 'servicio_id'], 'integer'],
            [['detalle'], 'string'],
            [['codcargo'], 'safe'],
            [['cant', 'punit', 'ptotal', 'igv', 'pventa', 'punitcalculado'], 'number'],
            [['item', 'tipo'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 60],
            [['codum'], 'string', 'max' => 4],
            [['flag'], 'string', 'max' => 1],
            [['codcargo'], 'string', 'max' => 6],
            [['codactivo'], 'string', 'max' => 10],
            [['coti_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComCotizacion::className(), 'targetAttribute' => ['coti_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'coti_id' => Yii::t('app', 'Coti ID'),
            'item' => Yii::t('app', 'Item'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codart' => Yii::t('app', 'Codart'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            'codum' => Yii::t('app', 'Codum'),
            'cant' => Yii::t('app', 'Cant'),
            'punit' => Yii::t('app', 'Punit'),
            'ptotal' => Yii::t('app', 'Ptotal'),
            'igv' => Yii::t('app', 'Igv'),
            'pventa' => Yii::t('app', 'Pventa'),
            'punitcalculado' => Yii::t('app', 'Punitcalculado'),
            'cotigrupo_id' => Yii::t('app', 'Cotigrupo ID'),
            'coticeco_id' => Yii::t('app', 'Coticeco ID'),
            'detcoti_id' => Yii::t('app', 'Detcoti ID'),
            'detcoti_id_id' => Yii::t('app', 'Detcoti Id ID'),
            'servicio_id' => Yii::t('app', 'Servicio ID'),
            'flag' => Yii::t('app', 'Flag'),
            'codcargo' => Yii::t('app', 'Codcargo'),
            'codactivo' => Yii::t('app', 'Codactivo'),
        ];
    }

    /**
     * Gets query for [[Coti]].
     *
     * @return \yii\db\ActiveQuery|ComCotizacionesQuery
     */
    public function getCoti()
    {
        return $this->hasOne(ComCotizacion::className(), ['id' => 'coti_id']);
    }

    /**
     * {@inheritdoc}
     * @return ComCotiDetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotiDetQuery(get_called_class());
    }
}

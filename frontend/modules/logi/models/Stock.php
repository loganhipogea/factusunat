<?php

namespace frontend\modules\logi\models;
use common\models\masters\Almacenes;
use common\models\masters\Centros;
use common\models\masters\Maestrocompo;
use Yii;

/**
  * @property Centros $codcen0
 */
class Stock extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock}}';
    }
     public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['batch'] = [
            'codart', 'codcen','codal',
            'um', 'ubicacion', 'cant',
            'valor', 'pventa'];
       return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codart', 'codcen','codal','cant'], 'required'],
            [['cant', 'cantres', 'valor', 'pventa', 'ceconomica', 'creorden', 'cminima'], 'number'],
            [['codart'], 'string', 'max' => 14],
            [['codcen', 'um', 'codal'], 'string', 'max' => 4],
            [['codart','codcen'], 'unique', 'targetAttribute' => ['codart','codcen']],
            [['ubicacion'], 'string', 'max' => 20],
            [['lastmov'], 'string', 'max' => 10],
            [['clas_abc'], 'string', 'max' => 1],
            [['codal'], 'exist', 'skipOnError' => true, 'targetClass' => Almacenes::className(), 'targetAttribute' => ['codal' => 'codal']],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codart' => Yii::t('base.names', 'Code'),
            'codcen' => Yii::t('base.names', 'Center'),
            'cant' => Yii::t('base.names', 'Cant'),
            'um' => Yii::t('base.names', 'Um'),
            'ubicacion' => Yii::t('base.names', 'Location'),
            'cantres' => Yii::t('base.names', 'Q reserved'),
            'codal' => Yii::t('base.names', 'Store'),
            'valor' => Yii::t('base.names', 'Unit value'),
            'lastmov' => Yii::t('base.names', 'Last mov'),
            'pventa' => Yii::t('base.names', 'Sell Value'),
            'ceconomica' => Yii::t('base.names', 'Ceconomica'),
            'creorden' => Yii::t('base.names', 'Creorden'),
            'cminima' => Yii::t('base.names', 'Cminima'),
            'clas_abc' => Yii::t('base.names', 'Clas Abc'),
        ];
    }

    /**
     * Gets query for [[Codal0]].
     *
     * @return \yii\db\ActiveQuery|AlmacenesQuery
     */
    public function getAlmacen()
    {
        return $this->hasOne(Almacenes::className(), ['codal' => 'codal']);
    }

    /**
     * Gets query for [[Codart0]].
     *
     * @return \yii\db\ActiveQuery|MaestrocompoQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|CentrosQuery
     */
    public function getCentro()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    /**
     * {@inheritdoc}
     * @return StockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StockQuery(get_called_class());
    }
}

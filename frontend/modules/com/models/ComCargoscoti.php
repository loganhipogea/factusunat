<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "{{%com_cargoscoti}}".
 *
 * @property int $id
 * @property int|null $coti_id
 * @property int|null $cargo_id
 * @property float|null $porcentaje
 * @property float|null $monto
 *
 * @property ComCargo $cargo
 * @property ComCotizacione $coti
 */
class ComCargoscoti extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_cargoscoti}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coti_id', 'cargo_id'], 'integer'],
            [['porcentaje','cargo_id'], 'required'],
            [['porcentaje', 'monto'], 'number'],
            [['cargo_id', 'coti_id'], 'safe'],
            [['cargo_id', 'coti_id'], 'unique', 'targetAttribute' => ['cargo_id','coti_id']],
            [['cargo_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComCargos::className(), 'targetAttribute' => ['cargo_id' => 'id']],
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
            'cargo_id' => Yii::t('app', 'Cargo ID'),
            'porcentaje' => Yii::t('app', 'Porcentaje'),
            'monto' => Yii::t('app', 'Monto'),
        ];
    }

    /**
     * Gets query for [[Cargo]].
     *
     * @return \yii\db\ActiveQuery|ComCargoQuery
     */
    public function getCargo()
    {
        return $this->hasOne(ComCargos::className(), ['id' => 'cargo_id']);
    }

    /**
     * Gets query for [[Coti]].
     *
     * @return \yii\db\ActiveQuery|ComCotizacioneQuery
     */
    public function getCoti()
    {
        return $this->hasOne(ComCotizacion::className(), ['id' => 'coti_id']);
    }

    /**
     * {@inheritdoc}
     * @return ComCargoscotiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCargoscotiQuery(get_called_class());
    }
    
    public function afterSave($insert, $changedAttributes) {
        if($insert or in_array('porcentaje',$changedAttributes)){
            $this->coti->refreshMonto();
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete() {
         $this->coti->refreshMonto();
        return parent::afterDelete();
    }
}

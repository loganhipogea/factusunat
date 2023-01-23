<?php

namespace frontend\modules\com\models;

use Yii;
use frontend\modules\cc\models\CcCc;
use frontend\modules\com\models\ComCotizacion;
/**
 * This is the model class for table "com_coticeco".
 *
 * @property int $id
 * @property int|null $coti_id
 * @property int|null $ceco_id
 * @property string|null $tipo
 * @property string|null $descricecoti
 * @property string|null $detalle
 *
 * @property CcCc $ceco
 * @property ComCotizacione $coti
 */
class ComCoticeco extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'com_coticeco';
    }
     public function behaviors() {
        return [
           
            /*'fileBehavior' => [
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
            [['coti_id', 'ceco_id'], 'integer'],
            [['detalle'], 'string'],
             [['subto'], 'safe'],
            [['tipo'], 'string', 'max' => 1],
            [['descricecoti'], 'string', 'max' => 40],
            [['ceco_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcCc::className(), 'targetAttribute' => ['ceco_id' => 'id']],
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
            'ceco_id' => Yii::t('app', 'Ceco ID'),
            'tipo' => Yii::t('app', 'Tipo'),
            'descricecoti' => Yii::t('app', 'Descricecoti'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * Gets query for [[Ceco]].
     *
     * @return \yii\db\ActiveQuery|CcCcQuery
     */
    public function getCeco()
    {
        return $this->hasOne(CcCc::className(), ['id' => 'ceco_id']);
    }
    
    public function getDetail()
    {
        return $this->hasMany(ComDetcoti::className(), ['coticeco_id' => 'id']);
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
     * @return ComCoticecoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCoticecoQuery(get_called_class());
    }
    
    public function refreshSubto($update_database=true){
        $this->subto=$this->getDetail()->
         select('sum(ptotal)')->scalar();
        yii::error($this->getDetail()->
         select('sum(ptotal)')->createCommand()->rawSql,__FUNCTION__);
        
        if($update_database)
        return $this->save();
        return true;
    }
}

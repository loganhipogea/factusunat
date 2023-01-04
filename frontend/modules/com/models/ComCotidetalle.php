<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "{{%com_detcoti}}".
 *
 * @property ComCotizacione $coti
 */
class ComCotidetalle extends \common\models\base\modelBase
{
    
    const SCE_HERRAMIENTAS='SH';
    const SCE_SERVICIO='SS';
    const SCE_MANO_OBRA='SM';
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
             [['punit','cant'], 'required'],
            [['codactivo'], 'required','on'=>self::SCE_HERRAMIENTAS],
            [['codcargo'],'required','on'=>self::SCE_MANO_OBRA],
                
            [['cant', 'punit', 'ptotal', 'igv', 'pventa', 'punitcalculado'], 'number'],
            [['item', 'tipo'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 60],
            [['codum'], 'string', 'max' => 4],
            [['flag'], 'string', 'max' => 1],
            [['codcargo'], 'string', 'max' => 6],
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
        ];
    }

    
     public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_HERRAMIENTAS] = [
            'codactivo', 'descripcion','codum',
            'cant', 'punit', 'ptotal','punitcalculado',
            'cotigrupo_id', 'coticeco_id', 'detcoti_id',
             'detcoti_id_id','servicio_id'
            ];
        $scenarios[self::SCE_SERVICIO] = [
             'codactivo', 'descripcion','codum',
            'cant', 'punit', 'ptotal','punitcalculado',
            'cotigrupo_id', 'coticeco_id', 'detcoti_id',
             'detcoti_id_id','servicio_id'
            ];
        $scenarios[self::SCE_MANO_OBRA] = [
             'codactivo', 'descripcion','codum',
            'cant', 'punit', 'ptotal','punitcalculado',
            'cotigrupo_id', 'coticeco_id', 'detcoti_id',
             'detcoti_id_id','servicio_id'
            ];        
       return $scenarios;
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
     * @return ComCotiDetalleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotidetalleQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($this->isScenario(self::SCE_MANO_OBRA)){
           if($this->hasChanged('punit')){
               
           }
        }
        
        return parent::beforeSave($insert);
    }
    
    
    public function detectChangeSensible(){
        return $this->hasChanged('cant') ||
                $this->hasChanged('punit') ||
                $this->hasChanged('codactivo') ||
                $this->hasChanged('servicio_id') ||
                $this->hasChanged('codcargo');
                
    }
    
    
    public function calculaPunit(){
       $escenario=$this->getScenario();
        switch ($escenario) {
    case self::SCE_HERRAMIENTAS:
        echo "i es igual a 0";
        break;
    case self::SCE_MANO_OBRA:
        
        break;
    case self::SCE_SERVICIO:
        echo "i es igual a 2";
        break;
        }
        
    }
    
  
    
}

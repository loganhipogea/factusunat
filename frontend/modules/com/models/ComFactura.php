<?php
namespace frontend\modules\com\models;
use Yii;
/**

 */
class ComFactura extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_factura}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codsoc'], 'string', 'max' => 1],
            [['numero'], 'string', 'max' => 13],
            [['femision', 'fvencimiento'], 'string', 'max' => 10],
            [['sunat_tipodoc', 'tipopago'], 'string', 'max' => 2],
            [['codmon'], 'string', 'max' => 4],
            [['codcen'], 'string', 'max' => 5],
              [['serie'], 'safe'],
            [['codcen'], 'safe',],
            [['rucpro'], 'string', 'max' => 14],
            [['sunat_hemision'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'numero' => Yii::t('base.names', 'Numero'),
            'femision' => Yii::t('base.names', 'Femision'),
            'fvencimiento' => Yii::t('base.names', 'Fvencimiento'),
            'sunat_tipodoc' => Yii::t('base.names', 'Sunat Tipodoc'),
            'codmon' => Yii::t('base.names', 'Codmon'),
            'tipopago' => Yii::t('base.names', 'Tipopago'),
            'rucpro' => Yii::t('base.names', 'Rucpro'),
            'sunat_hemision' => Yii::t('base.names', 'Sunat Hemision'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ComFacturaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComFacturaQuery(get_called_class());
    }
    
    private function correlative($prefix){
       $siguiente=  $this->find()->andWhere(['serie'=>$prefix])->count() +1;
       return str_pad($siguiente.'',8,'0',STR_PAD_LEFT);
       
    }
    
    public function beforeSave($insert) {
        IF($insert){
          $this->serie='F01';  
          $this->numero= $this->serie.'-'.$this->correlative($this->serie);
        }        
        return parent::beforeSave($insert);
    }
}

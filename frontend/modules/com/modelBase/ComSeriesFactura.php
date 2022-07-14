<?php

namespace frontend\modules\com\modelBase;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%com_series_factura}}".
 *
 * @property int $id
 * @property string|null $serie
 * @property string|null $codcen
 * @property string|null $tipodoc
 */
class ComSeriesFactura extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_series_factura}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codcen','tipodoc','serie'], 'required'],
        
            [['serie'], 'match', 'pattern' => h::gsetting('com','formatoSeries')],
            [['codcen'], 'string', 'max' => 5],
            [['tipodoc'], 'string', 'max' => 2],
            [['codcen','tipodoc'], 'unique', 'targetAttribute' =>['codcen','tipodoc']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'serie' => Yii::t('base.names', 'Serie'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'tipodoc' => Yii::t('base.names', 'Tipodoc'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ComSeriesFacturaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComSeriesFacturaQuery(get_called_class());
    }
    
    public static function serie($codocu,$codcen){
       //print_r(h::sunat()->graw('s01.tipodoc')->combo()->data);die();
       if(is_null($s=self::find()->andWhere(['tipodoc'=>$codocu,'codcen'=>$codcen])->one())){
           h::session()->setFlash('warning',yii::t('base.verbs','You must set the serial for document {document} in {center}',
                   [
                       'document'=>h::sunat()->graw('s.01.tdoc')->combo()->data[$codocu],
                       'center'=>$codcen]));
           return h::currentController()->redirect(['/masters/centros'])->send();
       }
       return $s->serie;
        
    }
}

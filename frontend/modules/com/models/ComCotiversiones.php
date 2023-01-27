<?php

namespace frontend\modules\com\models;
use common\behaviors\FileBehavior;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%com_cotiversiones}}".
 *
 * @property int $id
 * @property int|null $coti_id
 * @property float|null $numero
 * @property string|null $cuando
 * @property string|null $detalles
 */
class ComCotiversiones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_cotiversiones}}';
    }
    public function behaviors() {
        return [
           
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
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
            [['coti_id'], 'integer'],
            [['numero'], 'number'],
            [['detalles'], 'string'],
            [['cuando'], 'string', 'max' => 19],
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
            'numero' => Yii::t('app', 'Numero'),
            'cuando' => Yii::t('app', 'Cuando'),
            'detalles' => Yii::t('app', 'Detalles'),
        ];
    }

    
    public function getCoti(){
         return $this->hasOne(ComCotizacion::className(), ['id' => 'coti_id']);
    }
    /**
     * {@inheritdoc}
     * @return ComCotiversionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotiversionesQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        yii::error('before save',__FUNCTION__);
            yii::error(round(rand(1,3)/4,2),__FUNCTION__);
             yii::error($this->coti->version,__FUNCTION__);
            $this->numero=empty($this->coti->version)?0:$this->coti->version+round(rand(1,5)/4,2);
            $this->cuando=date(\common\helpers\timeHelper::formatMysqlDateTime());
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        if($insert)
        ComCotizacion::updateAll(['version'=>$this->numero],['id'=>$this->coti_id]);
        return parent::afterSave($insert, $changedAttributes);
    }
    
    
    
     public function pathTempToStore($name=null){
       $dir=\yii::getAlias('@frontend/web/com/temp/');
            if(!is_dir($dir)){
             mkdir($dir);
            }
        if(is_null($name))
            return $dir.uniqid().'.pdf';
            return $dir.$name.'.pdf';
      }
      
      public function attachPdf(){
        
          $contenido=h::currentController()->render('reporte_coti',['model'=>$this->coti]);
           $pdf= ComCotizacion::getPdf();
          $pdf->WriteHTML($contenido);
            
                 yii::error('escribiendo en disco',__FUNCTION__);
                $ruta=$this->pathTempToStore();
                 yii::error('ruta '.$ruta,__FUNCTION__);
                  yii::error('haciendo el  output al file  '.$ruta,__FUNCTION__);
                $pdf->output($ruta, \Mpdf\Output\Destination::FILE);  
                yii::error('YA BHIZO EK OUTPUR '.$ruta,__FUNCTION__);
                
                $this->deleteAllAttachments();
                $this->attachFromPath($ruta);
                @unlink($ruta);
      
      }

} 
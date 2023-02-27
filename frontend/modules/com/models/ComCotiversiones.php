<?php

namespace frontend\modules\com\models;
use common\behaviors\FileBehavior;
use common\helpers\FileHelper;
use common\helpers\h;
use common\helpers\timeHelper;
use common\models\masters\Contactos;
use yii\imagine\Image;
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
            [['lastlog_id'], 'safe'],

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
    
     public function getEnvios(){
         return $this->hasMany(ComCotienvios::className(), ['id' => 'version_id']);
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
         $controlador=h::currentController();
         $modelCoti=$this->coti;
         $controlador->layout="reportes";
         $formato=h::formato();
         $simbolo=$simbolo= \common\models\masters\Monedas::Simbolo($modelCoti->codmon);
         $contenido=$controlador->render('reporte_coti',['model'=>$modelCoti]); 
          $pdf= ComCotizacion::getPdf();
          if($modelCoti->isAprobed()){
                $pdf->SetWatermarkText('SIN APROBACION');
                $pdf->showWatermarkText = true;
          }
          
         
          
          $pdf->WriteHTML($contenido);
          
          /*aqui agregamos los adjuntos*/
             $contadorAnexos=0;
            foreach($modelCoti->adjuntos as $adjunto){
                $contadorAnexos++;
                if($adjunto->hasAttachments()){
                    
                    if(FileHelper::isImage($adjunto->files[0]->path)){
                        $pdf->addPage();
                        $pdf->WriteHTML(self::printAnexo($contadorAnexos));
                         $pdf->addPage();
                        $pdf->WriteHTML($this->htmlImage($adjunto->files[0]->path,$adjunto->detalle));
                    }else{
                        
                         $pdf->addPage();
                        $pdf->WriteHTML(self::printAnexo($contadorAnexos));
                         $pdf->addPage();
                        $pagecount = $pdf->setSourceFile($adjunto->files[0]->path);
                                for ($i=1; $i<=($pagecount); $i++) {
                                $pdf->AddPage();
                                $import_page = $pdf->ImportPage($i);
                                $pdf->UseTemplate($import_page);
                                    }                                    
                    }
                }
            }
          
          
          
          /*fin de agregar los adjunts*/
          
          
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
   public function mailCotizacion(){  
         $mensajes=[];
         $coti=$this->coti;
         $destinatarios=$this->coti->getContactos()->alias('a')->select(['b.mail'])->
          innerJoin(Contactos::tableName().' b','a.contacto_id=b.id')->column();
         
         $names=h::user()->getProfile()->names;
         
         if(is_null($names) or $names===''){
             $mensajes['error']=yii::t('base.errors','Su perfil de usuario no registra un nombre, registre su identidad');
         }elseif(!$this->hasAttachments()){
            $mensajes['error']=yii::t('base.errors','Esta versión no contiene archivo adjunto'); 
         }
         elseif(!(count($destinatarios)>0)){
           $mensajes['error']=yii::t('base.errors','No se han registrado destinatarios'); 
          }else{
          
              $mailer = new \common\components\Mailer();
            $message =new  \yii\swiftmailer\Message();
            $message->setSubject('COTIZACION'.' '.$coti->numero.' '.substr($coti->descripcion,23))
            ->setFrom([h::userEmail()=>$names])
            ->setTo($destinatarios)
             ->attach($this->files[0]->path)
            ->SetHtmlBody(timeHelper::saludo().' Estimado '
                    . 'adjunto encontrará nuestra propuesta económica por el servicio de '
                    . $this->coti->descripcion.' Cualquier inquietud no duden en comunicarse con nosotros');           
                try {        
                $result = $mailer->send($message);
                $this->prepareEnvio('OK');
                
                $mensajes['success']='Se envió el correo';
                } catch (\Swift_TransportException $Ste) {      
                        $mensajes['error']=$Ste->getMessage();
                     $this->prepareEnvio(substr($Ste->getMessage(),0,14));   
                }
         } 

      return $mensajes;
    }
  
  /*
   * Coloca los datos del envio
   */
  private function prepareEnvio($exito){
      $model=new ComCotienvios();
      $model->setAttributes([
          'version_id'=>$this->id,
          'coti_id'=>$this->coti_id,
          'exito'=>$exito,
          'cuando'=>self::SwichtFormatDate(date(timeHelper::formatMysqlDateTime()),'datetime',true)
      ]);
      //var_dump($model->cuando);die();
      return  $model->save();
  }  
    
    
   public function hasSends(){
       return $this->getEnvios()->count() >0;
   } 
   
   private function htmlImage($filePath,$texto){
       Image::resize($filePath, 2000, null, true, false);
       return "<div style='top:250px;text-align:center;border-style:solid; border-color:#ccc;padding:5px;boder-width:1px;'><img src='".$filePath."'><br><p>".$texto."<p></div>";
   }
   
   private static function printAnexo($number){
       return "<div style= 'display: flex;     
                align-items: center;
                justify-content: center;top:900px;'>
                    <div style='text-align: center;
                            font-size:3em;font-weight:800;'>ANEXO ".$number.""
                    . "</div>"
               . "</div>";
   }
} 
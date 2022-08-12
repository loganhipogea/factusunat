<?php
namespace common\models;
use nemmo\attachments\models\File as Fileb;
use common\models\base\modelBase;
use common\helpers\h;
//use nemmo\attachments\ModuleTrait;
use common\helpers\FileHelper;
use Yii;

use yii\helpers\Url;

class File extends Fileb
{
     public $cuando1=null; 
    
     public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codocu' => Yii::t('base.names', 'Documento'),
            'titulo' => Yii::t('base.names', 'Título'),
           // 'photo' => Yii::t('base.names', 'Foto'),
            'detalle' => Yii::t('base.names', 'Detalle'),
            'cuando' => Yii::t('base.names', 'F subida'),
             'user_id' => Yii::t('base.names', 'Usuario'),
            'size' => Yii::t('base.names', 'Tamaño'),
            //'durationabsolute' => Yii::t('base.names', 'Duracion absoluta'),
        ];
    }
    
    /*public function getDocumento()
    {
        if(!empty($this->codocu))
        return $this->hasOne(masters\Documentos::className(), ['codocu' => 'codocu']);
        return null;
    }*/
    

   /*
    * Funcion que hace u archivo de upolodas
    * lo publica en la carpeta WEB
    * esto para 
    * que pueda ser embebido dentro de un HTML
    * NO USAR ESTA FUNCION EN DOCUMENTOS PRIVADOS 
    * PORQUE SE REVELA SU RUTA
    */
   public function getUrlTempWeb(){
       $dir=\Yii::getAlias("@frontend/web/temp");
      if(!is_dir($dir)){
        mkdir($dir); 
      }
      $nameFile=uniqid().'.'.$this->type;
      $endPath=$dir.DIRECTORY_SEPARATOR.$nameFile;
      
      if(@copy($this->path,$endPath)){
           return Url::toRoute(['/temp/'.$nameFile]);
      }else{
          return false;
      }
   }
   
  public function isImage(){
      return in_array($this->type, FileHelper::extImages());
  }
   public function isPdf(){
      return in_array($this->type, ['pdf']);
  }
  public function beforeSave($insert) {
      if($insert && empty($this->titulo)) {
         $this->titulo='Sin título';
         $this->cuando=date('Y-m-d H:i:s');
         $this->user_id=h::userId();
      }
      return parent::beforeSave($insert);
  } 
}



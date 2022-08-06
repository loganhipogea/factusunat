<?php
namespace common\models;
use nemmo\attachments\models\File as Fileb;
//use nemmo\attachments\ModuleTrait;
use common\helpers\FileHelper;
use Yii;

use yii\helpers\Url;

class File extends Fileb
{
    
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
   
}



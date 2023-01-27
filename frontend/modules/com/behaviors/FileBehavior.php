<?php
namespace frontend\modules\com\behaviors;
use common\behaviors\FileBehavior as Fileb;

class FileBehavior extends  Fileb
{
   public function dirFile(){
       return $this->getModule()->getUserDirPath();
   } 
   
}

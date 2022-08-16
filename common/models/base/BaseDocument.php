<?PHP
namespace common\models\base;

class BaseDocument extends \common\models\base\modelBase
{
    const ST_CREATED='10';
    const ST_CANCELED='99';
    const ST_PASSED='20';
   public $nameFieldEstado='codestado'; 
   public function estados(){
       return[
           self::ST_CREATED=>\yii::t('base.names','CREADO'),
            self::ST_PASSED=>\yii::t('base.names','APROBADO'),
           self::ST_CANCELED=>\yii::t('base.names','ANULADO'),
       ];
   }
   public function statusText(){
       $esf=$this->estados();
       IF(array_key_exists($this->{$this->nameFieldEstado}, $esf))
       return $this->estados()[$this->{$this->nameFieldEstado}];
       return '';
   }
   
  public function isCreated(){
      return(self::ST_CREATED==$this->{$this->nameFieldEstado});
  }
  
  public function setCreated(){
      $this->{$this->nameFieldEstado}=self::ST_CREATED;
      return $this;
  } 
  
  
  public function isRemoved(){
      return(self::ST_CANCELED==$this->{$this->nameFieldEstado});
  }
  
   public function setRemoved(){
      $this->{$this->nameFieldEstado}=self::ST_CANCELED;
      return $this;
  }
  
  public function isPassed(){
      return(self::ST_PASSED==$this->{$this->nameFieldEstado});
  }
  
  public function setPassed(){
      $this->{$this->nameFieldEstado}=self::ST_PASSED;
      return $this;
  } 
  
  
}

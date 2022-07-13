<?PHP
namespace common\models\base;

class BaseDocument extends \common\models\base\modelBase
{
    const ST_CREATED='10';
    const ST_CANCELED='99';
    const ST_PASSED='20';
    
   public function estados(){
       return[
           self::ST_CREATED=>\yii::t('base.names','CREADO'),
            self::ST_PASSED=>\yii::t('base.names','APROBADO'),
           self::ST_CANCELED=>\yii::t('base.names','ANULADO'),
       ];
   }
   public function statusText(){
       $esf=$this->estados();
       IF(array_key_exists($this->codestado, $esf))
       return $this->estados()[$this->codestado];
       return '';
   }
    
}

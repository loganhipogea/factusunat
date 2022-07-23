<?php
/*
 * TRAIT DE USO general para saber 
 * por ejemplo si una feha e sferiado o no
 */
namespace frontend\modules\cc\traits;
use common\helpers\h;
use yii;

trait CcTrait
{
    
  public $codocu_compensacion=null;
  public $codocu_compesacion_hereda=null;
   public $codocu_cargo_rendir=null;
    public $codocu_fondo_fijo=null;
    public $codocu_cargo_devolucion_efectivo=null;
   public function __construct() {
           $this->codocu_compensacion=h::gsetting('cc','codocu_compensacion');
            $this->codocu_compesacion_hereda=h::gsetting('cc','codocu_compesacion_hereda');
        $this->codocu_cargo_rendir=h::gsetting('cc','codocu_cargo_rendir');
        $this->codocu_fondo_fijo=h::gsetting('cc','codocu_fondo_fijo'); 
        $this->codocu_cargo_devolucion_efectivo=h::gsetting('cc','codocu_cargo_devolucion_efectivo');
   } 
  
          
  public static function codigo_costo_directo(){
      return 'D';
  }
  public static function codigo_costo_indirecto(){
      return 'I';
  }
  
  public static function codigo_costo_orden(){
      return 'O';
  }
  public static function codigo_costo_sin_calificar(){
      return 'F';
  }
    
  public static function NombreCostoIndirecto(){
      return yii::t('base.labels','COSTO INDIRECTO');
        }
   public static function NombreCostoDirecto(){
      return yii::t('base.labels','COSTO DIRECTO');
        }     
    public static function NombreCostoOrden(){
      return yii::t('base.labels','ACUMULADO');
        } 
   public static function NombreCostoSinCalificar(){
      return yii::t('base.labels','SIN CALIFICAR');
        } 
  public static function ColorCostoIndirecto(){
      return '#faa732';
        }
   public static function ColorCostoDirecto(){
      return '#FF339A';
        }     
    public static function ColorCostoOrden(){
      return '#5deaee';
        } 
   public static function ColorCostoSinCalificar(){
      return '#F2F2F2';
        } 
  public static function ArrayLabelsTiposCostos(){
     return [
         self::NombreCostoDirecto(),
         self::NombreCostoIndirecto(),
         self::NombreCostoOrden(),
         self::NombreCostoSinCalificar()
         ] ;
  }
  public  function ArrayColorsPorTipo(){
     return [
         self::codigo_costo_directo()=> self::ColorCostoDirecto(),
          self::codigo_costo_indirecto()=> self::ColorCostoInDirecto(),
          self::codigo_costo_orden()=> self::ColorCostoOrden(),
          self::codigo_costo_sin_calificar()=> self::ColorCostoSinCalificar(),
         ] ;
  }
  
   public  function ArrayNombresCostos(){
     return [
         self::codigo_costo_directo()=> self::NombreCostoDirecto(),
          self::codigo_costo_indirecto()=> self::NombreCostoIndirecto(),
          self::codigo_costo_orden()=> self::NombreCostoOrden(),
          self::codigo_costo_sin_calificar()=> self::NombreCostoSinCalificar()
         ] ;
  }
  
  public static  function FondosFijos(){
    return ['100'=>'FONDO FIJO 1','200'=>'FONDO FIJO 2'];   
  }
  
}

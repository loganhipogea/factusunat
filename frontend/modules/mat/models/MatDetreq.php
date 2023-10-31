<?php

namespace frontend\modules\mat\models;
use frontend\modules\mat\interfaces\ReqInterface;
use common\helpers\h;
use frontend\modules\mat\Module as ModuloMateriales;
use Yii;

class MatDetreq extends \common\models\base\modelBase 
implements ReqInterface
{
    const SCE_IMPUTADO='sce_imputado';
    const SCE_SERVICIO='sce_servicio';
    const TIPO_MATERIALE='MAT';
    const TIPO_SERVICIO='SER';
    const EST_CRE='10';
    const EST_APRO='20';
    const EST_ANU='99';
    const EST_RESERVADO='50';
    const EST_ATENDIDO_PARCIAL='30';
    const EST_ATENDIDO='40';
    
    
    const TIPO_IMPU_ORDEN='O';
     const TIPO_IMPU_CECO='C';
     
    //const SC='sce_imputado';
   public $boolean_fields=['activo'];
   private $_cantreal=null;
   private $_lastRegistro=null;
   private $_stock;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detreq}}';
    }
   
    
     public function behaviors()
         {
                return [
		
		'fileBehavior' => [
			'class' => '\common\behaviors\FileBehavior' 
                               ],
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
       $reglas= [
            [['codart','tipo','codal','codpro','codest','ceco_id'] ,'safe'],
            
             [['cant','tipo',] ,'required'],
             [['cant','req_id','cant','item','tipo',
                 'um','activo','descripcion','texto','os_id','detos_id','proc_id'], 'safe'],
            //[['detos_id','proc_id','os_id'] ,'required', 'on'=>self::SCE_IMPUTADO],
             //[['ceco_id'] ,'verify_imputacion'],
            
            [['req_id'], 'integer'],
            [['cant'], 'number'],
            [['texto'], 'string'],
            [['codart', 'imptacion'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 40],
            [['um'], 'string', 'max' => 4],
            [['tipim'], 'string', 'max' => 1],
            [['req_id'], 'exist', 'skipOnError' => true, 'targetClass' => MatReq::className(), 'targetAttribute' => ['req_id' => 'id']],
        ];
       
       if($this->isCreatedFromCeco()){
           $reglas[]=[['ceco_id','codal','codart','um'] ,'required'];
       }
       if($this->isMaterial()){
           $reglas[]=[['codart','um','codal'] ,'required'];
       }
       if($this->isServicio()){
           $reglas[]=[['descripcion','servicio_id'] ,'required'];
       }
       
       return $reglas;
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'req_id' => Yii::t('base.names', 'Req ID'),
            'codart' => Yii::t('base.names', 'Código'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'codpro' => Yii::t('base.names', 'Prov Sugerido'),
            'cant' => Yii::t('base.names', 'Cant'),
            'um' => Yii::t('base.names', 'Um'),
            'imptacion' => Yii::t('base.names', 'Imputación'),
            'tipim' => Yii::t('base.names', 'Tip. imp'),
            'texto' => Yii::t('base.names', 'Texto'),
            
            
            'detos_id' => Yii::t('base.names', 'Actividad'),
            'proc_id' => Yii::t('base.names', 'Proceso'),
            'os_id' => Yii::t('base.names', 'Orden'),
        ];
    }

    public function scenarios() {
            $scenarios = parent::scenarios();
            $scenarios[self::SCE_IMPUTADO] = [ 
                'req_id',  'cant', 'valor', 'item', 'um','descripcion',
                'tipim','texto','codart',
                'os_id','detos_id','proc_id'
                ];
            $scenarios[self::SCE_SERVICIO] = [ 
                'req_id',  'cant', 'valor', 'item', 'descripcion',
               'texto',
                'os_id','detos_id','proc_id'
                ];
            //$scenarios[self::MOV_INGRESO] = [ 'vale_id', 'codart', 'cant', 'valor', 'item', 'um','descripcion','detreq_id'];
        
            return $scenarios;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReq()
    {
        return $this->hasOne(MatReq::className(), ['id' => 'req_id']);
    }
    
     public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['codart' => 'codart']);
    }

    
     public function getClipro()
    {
        return $this->hasOne(\common\models\masters\Clipro::className(), ['codpro' => 'codpro']);
    }
    
    
    public function getServicio()
    {
        return $this->hasOne(\common\models\masters\ServiciosTarifados::className(), ['id' => 'servicio_id']);
    }

    public function getCeco()
    {
        return $this->hasOne(\frontend\modules\cc\models\CcCc::className(), ['id' => 'ceco_id']);
    }

    
    public function getReservas()
    {
        return $this->hasMany(MatReservaDet::className(), ['detreq_id' => 'id']);
           //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }
    
    /* public function getStock()
    {
        return $this->hasOne(MatStock::className(), ['codart' => 'codart']);
    }*/
    /**
     * {@inheritdoc}
     * @return MatDetreqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatDetreqQuery(get_called_class());
    }
    
    public function anula($desactiva=true){
        if($desactiva){
            if($this->isCreado()){
               return $this->setAnulado()->save();
            }else{
               $this->addError('id',yii::t('base.errors','El estado de este registro no permite esta acción'));
               return false;
            }
        }else{
            /*
             * PENDIENTE PROGRAMAR LA REVERSA
             */
        }
        
    }
    
    public function isPosibleReserva(){
      return $this->stock()->cant_disp>0;
    }
    
    /*
     * Es la cantidad a reservar fijandose en el
     * stock, y tomado en cuenta tambien 
     * de las reservas anteriore hechas para este
     * item
     */
    public function cantAreservarDeStock(){
        $cant=$this->cantAReservar();
        if($cant > $this->stock()->cant_disp){
            return $this->stock()->cant_disp;
        }else{
            return $cant;
        }
    }
    
    public function reservar(){
        if($this->isReservable()){
            $cantidad=$this->cantAreservarDeStock();
             if($cantidad > 0){
                 return $this->stock()->createReserva($this->id,$cantidad); 
                            
                  }else{
                 return false;
                }
        }  
    }
    
     public function aprobar($aprobar=true){
         //yii::error('Entrando a la funcion',__FUNCTION__);
        if($aprobar){
            //yii::error('si aprobar',__FUNCTION__);
            if($this->isCreado()){   
                //yii::error('es creado',__FUNCTION__);              
               //yii::error($this->isMaterial(),__FUNCTION__);
               //yii::error(ModuloMateriales::isReservaAuto(),__FUNCTION__);
               if($this->isMaterial()){
                  
                   if(ModuloMateriales::isReservaAuto()){
                       //yii::error($this->cantAreservarDeStock(),__FUNCTION__);
                          $this->reservar();
                          return $this->setAprobado()->save(); 
                      
                       
                   }else{
                       
                       return $this->setAprobado()->save();
                   }
                   if(ModuloMateriales::isReqAuto()){
                       
                   }
                  
                   //En algunos casos no se puede crear reservca porque no hay stock
                  // if(!$ex) $this->addError('id','No se pudo crear la reserva');
                  return true;
               }else{
                   
               }
                
            }else{
               $this->addError('id',yii::t('base.errors','El estado de este registro no permite esta acción'));
               return false;
            }
            
        }else{
            /*
             * PENDIENTE PROGRAMAR LA REVERSA
             */
        }
        
    }
    
   
    
    
    
    
    public function beforeSave($insert) {
        if($insert){
            $this->ultimo= time();
            $this->setCreado();
            $this->activo=true;            
            $this->item='1'.str_pad($this->req->getDetalles()->count()+1,3,'0',STR_PAD_LEFT);
            $this->user_id=h::userId();
        }
        if($this->hasChanged('codart'))
          $this->descripcion=$this->material->descripcion;
        return parent::beforeSave($insert);
    }
    
  public function cantBase(){
        if(!empty($this->codart) ){
          return $this->cant/$this->material->factorConversion($this->um);
        }else{
            return $this->cant;
        }
             
    }
    
   
  public function verify_um() {
     if(!$this->material->existsUm($this->um,false)){
          $this->addError('um',yii::t('base.errors','La unidad de medida no está registrada'));
       }
  }
  
  
  public function verify_imputacion($attribute, $params) {
      yii::error('dsdsdsdsdsdsd',__FUNCTION__);
      yii::error($this->isCreatedFromCeco(),__FUNCTION__);
     yii::error(empty($this->ceco_id),__FUNCTION__);
     if($this->isCreatedFromCeco() && empty($this->ceco_id)){
          $this->addError('ceco_id',yii::t('base.errors','Debe ingresar el colector'));
       }
  }
  
  public function isMaterial(){
     return $this->tipo==self::TIPO_MATERIALE; 
  }
  public function isServicio(){
     return $this->tipo==self::TIPO_SERVICIO; 
  }
  
 public function validateServ($attribute, $params) {
        if($this->isServicio() && empty($this->codpro))
          $this->addError('codpro',yii::t('base.errors','Sugiera un proveedor de servicios'));
        
        if($this->isServicio() && empty($this->servicio_id))
          $this->addError('codpro',yii::t('base.errors','Catalogue el servicio'));
        
     
     }
  
  
  
  public function isActive(){
      return $this->activo;
  }
  
  
  
  
  /*Para aquellas requesiciones que son generadas 
   * dentro de una OT, es necesario automatizar 
   * el id 
   */
  public function detectaIdReq(){
      if(!$this->req_id>0){         
         $registro= $this->lastRegistro();         
         if(is_null($registro)){
             //yii::error('El registro es nulo',__FUNCTION__);
             return  self::createNewReq();
          }else{
               /*yii::error('El registro NO es nul EL ID ES '.$registro->id,__FUNCTION__);
               yii::error('El ultimo es '.$registro->ultimo,__FUNCTION__);
               yii::error('El time() es '.time(),__FUNCTION__);
               yii::error('La diferencia es '.(time()-$registro->ultimo),__FUNCTION__);
               */
              /*En caso hayan pasado una hora o la requesicion se haya aprobado o anulado    
               *Es mejor crear una nueva        */
              if($this->isPastHour() or $registro->req->isBloqueado()){
                   /*yii::error($this->isPastHour(),__FUNCTION__);
                    yii::error($registro->req->isBloqueado(),__FUNCTION__);
                     yii::error('eSTA CRENADO UNA NUEVA',__FUNCTION__);*/
                   return  self::createNewReq();
              }else{
                   //yii::error('NO CREA SOLO DEVUELVE EL ID',__FUNCTION__);
                  return $registro->req_id;
              }
          }
      }
    }
  
  
  
  public static function createNewReq(){
      $model= MatReq::instance();
      $model->setAttributes(
              [
                  'descripcion'=>'AUTO',
                  'auto'=>true,
                  'fechasol'=>self::SwichtFormatDate(self::CarbonNow()->format('Y-m-d'), 'date', true),
                  'fechaprog'=>self::SwichtFormatDate(self::CarbonNow()->format('Y-m-d'), 'date', true),
              ]
            );  
      if($model->save()){
          $model->refresh();
            return $model->id;
      }else{
         return -1; 
      }
      
     }
  
  
  public function setReservado(){
      $this->codest=self::EST_RESERVADO;
      return $this;
  }
  
  public function cantReservada(){
      return $this->getReservas()->sum('cant'); 
  } 
    
  public function isReservado(){
      return $this->cantBase() >= $this->cantReservada();
  }
  
  public function cantAReservar(){
      $dif=$this->cantBase()-$this->cantReservada();
      return ($dif>0)?$dif:0;
  }
  
  /*public function creaReserva(){
     if(!is_null($modelStock=$this->stock())){ 
        return  $modelStock->
           createReserva($this->req->reserva()->id,
                 $this->cantAReservar()
                 );         
     }else{
       return -1;  
     }      
  }*/
  
  public function stock(){
      if(is_null($this->_stock)){
         if(is_null($m= MatStock::findOne(['codart'=>$this->codart,'codal'=>$this->codal]))){
             yii::error('nulo',__FUNCTION__);
             $this->_stock=MatStock::createBasico($this->codart, $this->codal,$this->material->codum);
            yii::error($this->_stock,__FUNCTION__);
         }else{
             yii::error($m,__FUNCTION__);
            $this->_stock= $m; 
         }
            
             
             
      }
         return $this->_stock;
  }
  
  
 
  
  
  public function isCreado(){
      
       return $this->codest==self::EST_CRE  or empty($this->codest);
   }  
   
   public function isAprobado(){
       return $this->codest==self::EST_APRO;
   } 
   
   public function isAnulado(){
       return $this->codest==self::EST_ANU;
   } 
   
   public function isBloqueado(){
       return !$this->isCreado();
   }
   
   public function isReservable(){
       return !$this->isCreado() && !$this->isAnulado(); 
   }
   
   
   public function setAnulado(){
       $this->codest=self::EST_ANU;  
        return $this;
       
   }
   
   public function setCreado(){
       $this->codest=self::EST_CRE;       
        return $this;
   }
   
   public function setAprobado(){
       $this->codest=self::EST_APRO;       
       return $this;
   }
  
  public function setAtendido(){
      $this->codest=self::EST_ATENDIDO;
       return $this;
  }
  
  public function setAtendidoParcial(){
      $this->codest=self::EST_ATENDIDO_PARCIAL; 
       return $this;
  }
  
  
  private function deltaTime(){
       if(is_null($registro=$this->lastRegistro())){
          return 0;
      }else{
          
          return time()-$registro->ultimo;
      }   
  }
  
  
  
  public function isPastHour(){
     
      return $this->deltaTime()>60*60 or $this->deltaTime()==0; 
  }
  
  public function isPastWeek(){
      return $this->deltaTime()>60*60*24*7 or $this->deltaTime()==0; 
  }
  
  public function isPastDay(){
      return $this->deltaTime()>60*60*24 or $this->deltaTime()==0; 
  }
  
  /*
   * Si es creada a travez de una orden 
   * osea no ha sido creada directamente
   * 
   * Esto para proteger de la edicion 
   * directamente, solo puede modifcarse 
   * dentro de la orden o
   */
  public function isCreatedFromOrder(){
      return $this->detos_id>0; 
  }
  

  public function isCreatedFromCeco(){
      return $this->ceco_id>0 or $this->tipim==self::TIPO_IMPU_CECO; 
  }
  
  
  /*
   * Solo puede borrarse de la base de datos
   * si es nuevo o recien creado y ademas
   * no ha pasado mas de una hora de su creación   * 
   */
  public function canDelete(){
     return !$this->isBloqueado() && !$this->isPastHour();
  }
  
  
  public function hasReservas(){
      $this->getReservas()->count()>0;
  }
  
  
  private function lastRegistro(){
      if(is_null($this->_lastRegistro)){
          $registro= $this->find()->andWhere(['user_id'=>h::userId()])
                  ->andWhere(['>','ultimo',0])->
                  orderBy(['id'=>SORT_DESC])->one();
         $this->_lastRegistro=$registro;
         
      }
          return $this->_lastRegistro;
      }
  
  
  
}

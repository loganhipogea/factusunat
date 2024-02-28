<?php

namespace common\models\masters;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "maestrocompo_sol".
 *
 * @property string|null $codart
 * @property string|null $codum
 * @property string|null $descripcion
 * @property string|null $codfam
 * @property string|null $codsubfam
 * @property string|null $codsubsubfam
 * @property string|null $caracteristicas
 * @property int|null $nivel
 * @property string|null $npeq
 * @property string|null $infotecnica
 */
class MaestrocompoSol extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maestrocompo_sol_copy';
    }

    public $codsubsubfam_=null;
    
    public $dateorTimeFields = [
        'fecha_cre' => self::_FDATETIME,  
         
    ];
    
   
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
    
    
    
     public $booleanFields=['subido','activo'];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descrimanual','proyecto'], 'required'],   
             [['subido','activo'], 'validate_estado'],   
            [['nivel'], 'integer'],
            [['infotecnica'], 'string'],
            [['codart'], 'string', 'max' => 14],
            [['user_name'], 'string', 'max' => 50],
            [['user_name','subido','descrimanual','obs','proyecto','activo','user_name'], 'safe'],            
            [['codum'], 'string', 'max' => 4],
            [['descripcion', 'caracteristicas'], 'string', 'max' => 80],
            [['codfam', 'codsubfam',], 'string', 'max' => 2],
            [['npeq'], 'string', 'max' => 50],
            [['codart'], 'unique','skipOnEmpty'=>true],
            [['codart'], 'match','pattern'=>'/^[0-9]+$/','skipOnEmpty'=>true],
            [['codart'], 'valida_codigo','skipOnEmpty'=>true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codart' => Yii::t('app', 'Cod'),
            'codum' => Yii::t('app', 'Codum'),
            'descripcion' => Yii::t('app', 'Descripcion detallada'),
            'descrimanual' => Yii::t('app', 'Descripcion comercial(corta)'),
            'codfam' => Yii::t('app', 'Codfam'),
            'codsubfam' => Yii::t('app', 'Codsubfam'),
            'codsubsubfam' => Yii::t('app', 'Codsubsubfam'),
            'caracteristicas' => Yii::t('app', 'Caracteristicas'),
            'nivel' => Yii::t('app', 'Nivel'),
            'proyecto' => Yii::t('app', 'Primer uso'),
            'npeq' => Yii::t('app', 'Npeq'),
            'infotecnica' => Yii::t('app', 'Inf técnica'),
            'user_name' => Yii::t('app', 'Creado por'),
             'fecha_cre' => Yii::t('app', 'Fecha creación'),
            'obs' => Yii::t('app', 'Observación'),
            'caracteristicas' => Yii::t('app', 'Caracteristicas'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MaestrocompoSolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MaestrocompoSolQuery(get_called_class());
    }
    
    public static function familias(){
        $datos=[
           '10'=>'MODELO EQUIPOS',
           '11'=>'MODULOS PARA EQUIPOS',
           '12'=>'ENSAMBLE DISEÑO PROPIO',
           '13'=>'PARTES DISEÑO PROPIO',
           '14'=>'MERCADERIAS',   
            '15'=>'MATERIA PRIMA',
           ];
       return $datos;
    }
    public static function subfamilias($codfam){
        $datos=[
                '10'=>[
                        $codfam.'01'=>'EQUIPO DE PERFORACION',
                        $codfam.'02'=>'EQUIPO SOSTENIMIENTO DE ROCAS',
                        $codfam.'03'=>'EQUIPO PALAS Y CAMIONES (LHD)',
                        $codfam.'04'=>'EQUIPO UTILITARIO',
                    ],
                '11'=>[
                        $codfam.'01'=>'MODULOS EQUIPOS DE PERFORACION',
                        $codfam.'02'=>'MODULOS EQUIPOS SOSTENIMIENTO DE ROCAS',
                        $codfam.'03'=>'MODULOS PALAS Y CAMIONES (LHD)',
                        $codfam.'04'=>'MODULO UTILITARIOS',
                        $codfam.'05'=>'MODULOS EQUIPO CARGA DE EXPLOSIVOS',
                    ],
           '12'=>[
                $codfam.'01'=>'ENSAMBLES EQUIPOS DE PRODUCCION Y EMPERNADO',
                $codfam.'02'=>'ENSAMBLES EQUIPOS TRANSPORTADOR DE CONCRETO',
                $codfam.'03'=>'ENSAMBLES EQUIPOS PULVERIZADOR DE HORMIGON',
                $codfam.'04'=>'ENSAMBLES EQUIPOS DESATADOR SCALER',
                $codfam.'05'=>'ENSAMBLES PALAS -SCOOP',
                $codfam.'06'=>'ENSAMBLES EQUIPOS CAMIONES DUMPER',
                $codfam.'07'=>'ENSAMBLES UTILITARIO - PLATAFORMA LEVADIZA',
                $codfam.'08'=>'ENSAMBLE HERRAMIENTAS GENERALES',
                $codfam.'09'=>'ENSAMBLES DE EQUIPO PERFORACION FRONTAL',
                $codfam.'10'=>'ENSAMBLE EQUIPO CARGA DE EXPLOSIVOS ANFO Y EMULSION',
            ],
           '13'=>[
                    $codfam.'01'=>'PARTES UNICAS',
                    $codfam.'02'=>'PARTES GENERALES',
                    ],
           '14'=>  [$codfam.'01'=>'SIST HIDRAULICO',],
            '15'=>[
                $codfam.'01'=>'PLANCHAS',
                $codfam.'02'=>'PERFILES',
                $codfam.'03'=>'ACEROS',
                $codfam.'04'=>'BRONCES',
                $codfam.'05'=>'ALUMINIOS',
                $codfam.'06'=>'POLIMEROS',
                $codfam.'07'=>'INOXIDABLES',
                $codfam.'08'=>'FIERRO CONSTRUCCION',
                $codfam.'09'=>'FUNDICIONES',
                 $codfam.'10'=>'PIEZAS MECANIZADAS',
            ],
            
            
            
        ];
        //var_dump(in_array($codfam, $datos),$codfam);die();
       return (in_array($codfam,array_keys($datos)))?$datos[$codfam]:[];
    }
    
     public static function subsubfamilias($codsubfam){
        $datos=[
                
                        '1001'=>[
                                $codsubfam.'01'=>'PERFORACION FRONTAL (TRITON)',
                                $codsubfam.'02'=>'PERFORACION DE PRODUCCION (NAUTILUS)]'
                                ],
                        '1002'=>[
                                $codsubfam.'01'=>'SOSTENIMIENTO CON PERNO',
                                $codsubfam.'02'=>'SOSTENIMINETO CON CABLE',
                                $codsubfam.'03'=>'PULVERIZADOR HORMIGON',
                                $codsubfam.'04'=>'DESATADOR SCALER',
                                 $codsubfam.'05'=>'TRANSPORTADOR CONCRETO',
                                ],
                        '1003'=>[
                               $codsubfam.'01'=> 'EQUIPO PLATAFORMA LEVADIZA',
                               $codsubfam. '02'=>'CAMION LUBRICADOR',
                                $codsubfam.'03'=>'CAMION DE ANFO',
                                $codsubfam.'04'=>'CAMION TRANSPORTE PERSONAL',
                                $codsubfam.'05'=>'TRANSPORTADOR DE EQUIPOS',
                                ],
            
           
                        '1004'=>[
                                $codsubfam.'01'=> 'EQUIPO PLATAFORMA LEVADIZA',
            $codsubfam.'02'=> 'CAMION LUBRICADOR',
            $codsubfam.'03'=> 'CAMION DE ANFO',
            $codsubfam.'04'=> 'CAMION TRANSPORTE PERSONAL',
            $codsubfam.'05'=> 'TRANSPORTADOR DE EQUIPOS',
            $codsubfam.'06'=> 'EQUIPO CARGA DE EXPLOSIVOS',
            $codsubfam.'07'=> 'EQUIPOS MEZCLADORES DE CONCRETO',
                                ],
                  
                        '1101'=>[
                                $codsubfam.'01'=> 'PERFORACION FRONTAL (TRITON)',
                                $codsubfam.'02'=> 'PERFORACION DE PRODUCCION (NAUTILUS)',
                                    ],
            
                        '1102'=>[
                               $codsubfam. '01'=> 'SOSTENIMIENTO CON PERNOS',
                               $codsubfam. '02'=> 'SOSTENIMIENTO CON CABLE',
                               $codsubfam. '03'=> 'PULVERIZADOR DE HORMIGON',
                                 $codsubfam.'04'=> 'DESATADOR SCALER',
                               $codsubfam. '05'=> 'TRANSPORTADOR DE CONCRETO',
                                ],
            
                       '1103'=>[
                                $codsubfam.'01'=> 'CARGADOR DIESEL',
                                $codsubfam.'02'=> 'CAMION DIESEL',
                                
                             ],

                        '1104'=>[
                             $codsubfam.'01'=> 'Equipo Plataforma Levadiza',
                                $codsubfam.'02'=> 'Camión Lubricador',
                                $codsubfam.'03'=> 'Camión de Anfo',
                                 $codsubfam.'04'=> 'Camión Transporte de Personal',
                                $codsubfam.'05'=> 'Transportador de Equipos',   
                                
                             ],
                       '1105'=>[
                             $codsubfam.'01'=> 'Cargadores anfo',
                                $codsubfam.'02'=> 'Cargadores emuslion',
                               
                             ],







            
                '1201'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE INTERMEDIA',
                                $codsubfam.'03'=> 'ENSAMBLE PARTE POSTERIOR',
                                $codsubfam. '04'=> 'ENSAMBLE PARTE ARTICULACION Y CARDAN',
                                $codsubfam.'05'=> 'ENSAMBLE PARTE BRAZO',
                         ],
            
            '1202'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE POSTERIOR',
                                 $codsubfam.'03'=> 'ENSAMBLE PARTE ARTICULACION Y CARDAN',
                              
                         ],
            
            '1203'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE POSTERIOR',
                                $codsubfam.'03'=> 'ENSAMBLE PARTE BRAZO PULVERIZADOR',
                                 $codsubfam.'04'=> 'ENSAMBLE PARTE ARTICULACION Y CARDAN',
                               
                         ], 

                 '1204'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE POSTERIOR',
                                $codsubfam.'03'=> 'ENSAMBLE PARTE BRAZO DESATADOR',
                                 $codsubfam.'04'=> 'ENSAMBLE PARTE ARTICULACION Y CARDAN',
                               
                         ], 
             '1205'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE POSTERIOR',
                                $codsubfam.'03'=> 'ENSAMBLE PARTE BRAZO',
                                
                               
                         ], 
             '1206'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE POSTERIOR',
                               
                                
                               
                         ], 
             '1207'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE POSTERIOR',
                                $codsubfam.'03'=> 'ENSAMBLE PARTE ARTICULACION Y CARDAN',
                                
                               
                         ],
            
            '1208'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE POSTERIOR',
                                $codsubfam.'03'=> 'ENSAMBLE PARTE ARTICULACION Y CARDAN',
                                
                               
                         ],
            
             '1209'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE INTERMEDIA',
                                $codsubfam.'03'=> 'ENSAMBLE PARTE POSTERIOR',
                                 $codsubfam.'04'=> 'ENSAMBLE PARTE ARTICULACION Y CARDAN',
                                $codsubfam.'05'=> 'ENSAMBLE PARTE BRAZO',
                         ],
               
           '1210'=>[
                                $codsubfam.'01'=> 'ENSAMBLE PARTE DELANTERO',
                                $codsubfam.'02'=> 'ENSAMBLE PARTE INTERMEDIA',
                                $codsubfam.'03'=> 'ENSAMBLE PARTE POSTERIOR',
                                $codsubfam. '04'=> 'ENSAMBLE PARTE ARTICULACION Y CARDAN',
                                $codsubfam.'05'=> 'ENSAMBLE PARTE BRAZO',
                         ],
            
            
            
            
            
            


                    '1301'=>[
                                $codsubfam.'01'=> 'EQUIPO DE PERFORACION Y EMPERNADOR',
                                $codsubfam.'02'=> 'EQUIPO DE PERFORACION Y EMPERNADOR ll',
                                $codsubfam.'03'=> 'EQUIPO DE PERFORACION Y EMPERNADOR lll',
                                $codsubfam.'04'=> 'EQUIPO UTILITARIO - PLATAFORMA LEVADIZA',
                                $codsubfam.'05'=> 'HERRAMIENTAS GENERALES (MINERIA Y TALLER)',
                                $codsubfam.'06'=> 'MANGUERAS HIDRAULICAS  R2',
                                $codsubfam.'07'=> 'MAGUERA HIDRAULICA   R12',
                                $codsubfam.'08'=> 'EQUIPO TRANSPORTADOR DE CONCRETO ',
                                $codsubfam.'09'=> 'EQUIPO PULVERIZADOR DE HORMIGON ',
                                $codsubfam.'10'=> 'EQUIPO DESATADOR SCALER ',
                                    $codsubfam.'11'=> 'COMPONENTES DE PERFORADORA',
                                $codsubfam.'12'=> 'EQUIPO FRONTONERO',
                                $codsubfam.'13'=> 'EQUIPO DE PERFORACION Y EMPERNADOR IV',
                                   $codsubfam. '14'=> 'EQUIPO DE PERFORACION Y EMPERNADOR V',
                                   $codsubfam. '15'=> 'EQUIPO DE PERFORACION Y EMPERNADOR VI',
                                    $codsubfam.'16'=> 'EQUIPO DE PERFORACION Y EMPERNADOR VII',
                                        $codsubfam.'17'=> 'EQUIPO CAMION UTILITARIO - CAMION ANFO',
                                        $codsubfam.'18'=> 'EQUIPO CARGA DE EXPLOSIVOS ANFO Y EMULSION',
                         ],
                    '1302'=>[
                                        
                                    $codsubfam.'01'=> 'EQUIPO DE PERFORACION Y EMPERNADOR',
                                    $codsubfam.'02'=> 'EQUIPO PULVERIZADOR Y MEZCLADOR (CICLON/SPRAYMIX)',
                                    $codsubfam.'03'=> 'EQUIPO PALAS Y CAMIONES (LHD)',
                                    $codsubfam.'04'=> 'EQUIPO UTILITARIO',
                                    $codsubfam.'05'=> 'EQUIPO FRONTONERO II',
                         ],
       
                          '1401'=>[
                                        
                                    //$codsubfam.'01'=> 'EQUIPO DE PERFORACION Y EMPERNADOR',
                                    $codsubfam.'02'=> 'CILINDROS HIDRAULICOS',
                                   /* $codsubfam.'03'=> 'EQUIPO PALAS Y CAMIONES (LHD)',
                                    $codsubfam.'04'=> 'EQUIPO UTILITARIO',
                                    $codsubfam.'05'=> 'EQUIPO FRONTONERO II',*/
                         ],
            
            '1401'=>[
                                        
                                    $codsubfam.'01'=> 'SELLOS HIDRAULICOS',
                                    $codsubfam.'02'=> 'CILINDROS HIDRAULICOS',
                                    $codsubfam.'14'=> 'ACCESORIOS DE CILINDRO',
                                    /*$codsubfam.'04'=> 'EQUIPO UTILITARIO',
                                    $codsubfam.'05'=> 'EQUIPO FRONTONERO II',*/
                         ],
            
             '1503'=>[
                                        
                                    $codsubfam.'01'=> 'AISI 1045',
                                    $codsubfam.'02'=> 'AISI 4140 (VCL)',
                                    $codsubfam.'03'=> 'AISI 4340 (VCN)',
                                    $codsubfam.'04'=> 'AISI 3215 (ECN)',
                                    $codsubfam.'05'=> 'AM-BP',
                                    $codsubfam.'06'=> 'AISI 7210',
                                   // $codsubfam.'07'=> 'AISI 3215',
                         ],
            
            '1510'=>[
                                        
                                    $codsubfam.'01'=> 'PIEZAS BASICAS ACERO A36',
                                    $codsubfam.'02'=> 'PIEZAS BASICAS INOX C-304',
                                  
                         ],
        ];
       return in_array($codsubfam,array_keys($datos))?$datos[$codsubfam]:[];
    }
  
    private static function criteriaFam($codsubsubfam){
        return [
                    'codfam'=>substr($codsubsubfam, 0,2),
                    'codsubfam'=>substr($codsubsubfam, 2,2),
                    'codsubsubfam'=>substr($codsubsubfam, 4,2),
                ];
    }
    public static function items($codsubsubfam){
        
        $valores=self::find()->select(['descripcion','codart','subido'])->
                andWhere(self::criteriaFam($codsubsubfam))->orderBy(['codart'=>SORT_DESC])->asArray()->all();
        /*var_dump($codsubsubfam,[
                    'codfam'=>substr($codsubsubfam, 0,2),
                    'codsubfam'=>substr($codsubsubfam, 2,2),
                    'codsubsubfam'=>substr($codsubsubfam, 4,2),
                ],self::find()->select(['codart','descripcion'])->
                andWhere([
                    'codfam'=>substr($codsubsubfam, 0,2),
                    'codsubfam'=>substr($codsubsubfam, 2,2),
                    'codsubsubfam'=>substr($codsubsubfam, 4,2),
                ])->createCommand()->rawSql); die();*/
        return $valores;
        //return array_column($valores,'descripcion','codart');
    }
  public static function generateNodes($clave){
      if(strlen($clave)==2){
        
          RETURN self::generateBranches(self::subfamilias($clave));
      }elseif(strlen($clave)==4){
          RETURN self::generateBranches(self::subsubfamilias($clave),3);
      }elseif(strlen($clave)==6){
          RETURN self::generateBranches(self::items($clave),4);
      }
         
          
    }
 public static function generateTitleNode($icono,$icono_subido,$icono_pendiente,$codart,$descripcion,$subido){
      $url=\yii\helpers\Url::to(['/masters/materials/modal-edita-material-sol','id'=>$codart,'gridName'=>'grilla-arbol','idModal'=>'buscarvalor']);
              $link=\yii\helpers\Html::a('<i style="color:yellow; font-size:1em;"><span class="fa fa-pencil"></span></i>',$url,[
                            'class'=>"botonAbre",
                            'title' => yii::t('base.names','Agregar Colector'),
                        ]);
             return [
            'icon'=>$icono,//fa fa-cube
            'key'=>'_'.$codart,//'_'.$fila['codart'],
            'title'=>(($subido=='1')?'<span class="'.$icono_subido.'" style="color:#a7da19"></span>':'<span class="'.$icono_pendiente.'" style="color:orange"></span>').
                 '<span style="font-weight:900;">'.$codart.'</span>-'.
                 $descripcion.$link,
            'lazy'=>true,
            'tooltip'=>'fill-grupos-cargo_',
               ];
 }     
  private static  function generateBranches($arreglo,$level=null){
       $ramas=[];
       //var_dump($arreglo); die();
      $url='';$link='';
        if($level==4){
             
            foreach($arreglo as $fila){
              $url=\yii\helpers\Url::to(['/masters/materials/modal-edita-material-sol','id'=>$fila['codart'],'gridName'=>'grilla-arbol','idModal'=>'buscarvalor']);
              $link=\yii\helpers\Html::a('<i style="color:yellow; font-size:1em;"><span class="fa fa-pencil"></span></i>',$url,[
                            'class'=>"botonAbre",
                            'title' => yii::t('base.names','Agregar Colector'),
                        ]);
             $ramas[]=self::generateTitleNode(
                     'fa fa-cube',
                    "fa fa-arrow-up",
                     "fa fa-circle",                      
                     $fila['codart'], 
                     $fila['descripcion'],
                     $fila['subido']);
            
            }
        }else{
            
            foreach($arreglo as $clave=>$valor){
              if($level==3){
              $url=\yii\helpers\Url::to(['/masters/materials/modal-crea-material-sol','id'=>$clave,'gridName'=>'grilla-arbol','idModal'=>'buscarvalor']);
              $link=\yii\helpers\Html::a('<i style="color:#6f9e30; font-size:1em;"><span class="fa fa-plus-circle"></span></i>',$url,[
                            'class'=>"botonAbre",
                            'title' => yii::t('base.names','Agregar Colector'),
                        ]);
              }
             $ramas[]=[
            'icon'=>'fa fa-cube',
            'key'=>'_'.$clave,
            'title'=>'<span style="font-weight:900;">'.$clave.'</span>-'.$valor.$link,/*.
                     \yii\helpers\Html::a(   '<i style="color:#6f9e30;"><span class="fa fa-plus-circle"></span></i>',
                    \yii\helpers\Url::to(['/sigi/edificios/agrega-partida-tree','id'=>$fila->id,'gridName'=>'grilla-cuentas','idModal'=>'buscarvalor']),
                        [
                            'class'=>"botonAbre",
                            'title' => yii::t('sta.labels','Agregar Colector'),
                        ]
                    ),*/
            'lazy'=>true,
            'tooltip'=>'fill-grupos-cargo_',
               ];
            }
        }
        
       return $ramas;
  }
    
 public function validate_estado($attribute,$params){
     if($this->subido && !$this->activo)
      $this->adderror('activo',yii::t('base.errors','No puede anular un item que ya está cargado'));
     if(!$this->subido && $this->existsMaterial() )
      $this->adderror('subido',yii::t('base.errors','No puede cambiar este estado porque ya existe un material subido')); 
 } 
 
 public function existsMaterial(){
    return !is_null(Maestrocompo::find()->andWhere(['codart'=>$this->codart])->one());
 }
  
  
  
 public static function generateCode($codsubsubfam){
    $codmax=  self::find()->select('max(codart)')->where(self::criteriaFam($codsubsubfam))->scalar();
    if($codmax===false or $codmax===null)return $codsubsubfam.'001';
    return ''.($codmax+1);
 }
  public function beforeSave($insert) {       
        
        if($insert){
            if(empty($this->codart))
            $this->codart=$this->generateCode($this->codsubsubfam_);
           
            $this->user_name=h::userName();
           $this->fecha_cre= $this->currentDateInFormat(true);
            $this->codfam= substr($this->codart,0,2);
            $this->codsubfam= substr($this->codart,2,2);
            $this->codsubsubfam= substr($this->codart,4,2);
            $this->activo=true;
            
        }
        return parent::beforeSave($insert);
    }
  
 public function valida_codigo($params, $attribute){
     if(!(substr($this->codart,0,6)==$this->codsubsubfam_))
       $this->addError ('codart','El código asignado no pertenece a la clasificación');
     if(!(strlen($this->codart)==9))
       $this->addError ('codart','Longitud de  código asignado incorrecta, revise');
 } 
 
 
 public function afterSave($insert, $changedAttributes) {  
     if($this->activo){
     if($insert){
         if($this->subido){
            $this->createMaterial();
         }
     }else{
         if(in_array('subido',array_keys($changedAttributes))){
             if($this->subido){
                $this->createMaterial(); 
             }
         }
     }
     }
     return parent::afterSave($insert, $changedAttributes);
 }
 
 public function createMaterial(){
    if(is_null($modelo=Maestrocompo::find()->andWhere(['codart'=>$this->codart])->one())){
    $modelo= Maestrocompo::instance();
   
    $modelo->setAttributes([
                'codart'=>$this->codart,
               'codfam'=> substr($this->codart,0,2),
            'codsubfam'=> substr($this->codart,2,2),
            'codsubsubfam'=> substr($this->codart,4,2),
            'descripcion'=>$this->descripcion, 
            'codtipo'=>'100',
            'codum'=>'UND',
            'numeroparte'=>'',
        ]);
        //var_dump($modelo->save(),$modelo->getErrors());die();
         $modelo->save();
      }
   }
}

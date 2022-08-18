<?php

namespace common\tlbot;

use common\tlbot\base\Response;
use common\tlbot\base\TelegramBase;
use common\tlbot\types\User;
use common\models\TlbotUsers;
use common\tlbot\Telegram;
use common\models\TlbotHooks;
use common\models\TlbotMessages;
use common\models\Users;
use common\helpers\h;
use yii\validators\RegularExpressionValidator;
use frontend\modules\sta\staModule;
use frontend\modules\sta\models\Alumnos;
use frontend\modules\sta\models\Talleres;
use frontend\modules\sta\models\Talleresdet;
use frontend\modules\sta\models\Aluriesgo;
use common\helpers\FileHelper;
use yii;
use yii\web\Session;
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 */
class TelegramMinerva extends Telegram
{
   public $nombre='TEVEL';
   private $_preserveHtmlTags='<b><u><i><s><a><code><pre>';
 
   private $_tallerdet=null;
   public $_user=null;
    private $_sesion=null;
    public static $roles=['A','B','C','D'];
    private $campos_sesion=['comando','time','paso','esfinal'];
    const LEVEL_ANY='0';
    const LEVEL_ALU='1';
    const LEVEL_ADMIN='2';
    
    
    
    
    
    
    /*
     * ------------------------------------
     * campos array para almacenar los registros de repsiuesta
     * e una ssion
     * -------------------------------------
     * 
     */
    public static $map_comandos=[
                    'inichat'=>['funcion'=>'cmdChatea',
                                 'pasos'=>100,
                                 'user_level'=>self::LEVEL_ANY,
                                ],
                    'registro'=>['funcion'=>'cmdRegistroAlumno',
                                 'pasos'=>2,
                                 'user_level'=>self::LEVEL_ANY,
                                ],
                    'start'=>['funcion'=>'cmdSaludo',
                                 'pasos'=>1,
                                 'user_level'=>self::LEVEL_ANY,
                                ],
                    'escape'=>['funcion'=>'cmdClearComando',
                                 'pasos'=>1,
                                 'user_level'=>self::LEVEL_ANY,
                                ],
                    'registro_usuario'=>['funcion'=>'cmdRegistroUsuario',
                                 'pasos'=>2,
                                 'user_level'=>self::LEVEL_ANY,
                                ],
                      'eventos'=>['funcion'=>'cmdEventos',
                                 'pasos'=>1,
                                 'user_level'=>self::LEVEL_ALU,
                                ],
                     'proximacita'=>['funcion'=>'cmdRegistroUsuario',
                                 'pasos'=>1,
                                 'user_level'=>self::LEVEL_ALU,
                                ],
                     'citas'=>['funcion'=>'cmdCitas',
                                 'pasos'=>1,
                                   'user_level'=>self::LEVEL_ALU,
                                ],
                    'noticitashoy'=>['funcion'=>'cmdNotiCitasHoy',
                                 'pasos'=>1,
                                   'user_level'=>self::LEVEL_ADMIN,
                                ],
                     'notievento'=>['funcion'=>'cmdNotiEvento',
                                 'pasos'=>1,
                                   'user_level'=>self::LEVEL_ADMIN,
                                ],
                       'recursos'=>['funcion'=>'cmdRecursos',
                                 'pasos'=>1,
                                   'user_level'=>self::LEVEL_ALU,
                                ],
                    'ayuda'=>['funcion'=>'cmdAyuda',
                                 'pasos'=>1,
                                 'user_level'=>self::LEVEL_ANY,
                                ],
        
                   
                ];  
    
    
    
    public static $lisuras=['mierda','carajo','puta','pvta','ctmr',
             'ctmre','mrd','conchatumare','conchatumadre',
             'concha tumare','concha tu madre','concha tu mare',
             'chatumare','idiota','baboso','imbécil','imbecil', 'culo',
             'chucha','puta mare','ptmr','cagada','pinga','chupa pinga',
             'chupapinga','cabro','maricon','huevon','hijoeputa', 'hijo de puta',
             'hijo e puta', 'culo roto','culoroto','verga','chupa verga',
             'mama huevo ','mama huevo', 'cachera','cachero','cachería','cachar'         
             ];
    public static $posibles_respuestas=[
        'De nada '=>['Gracias','Muchas gracias','Te pasaste',
            'Gracias por todo','Thanks','Muy agradecido'
            
        ],
        'No sé si te deseo lo mismo'=>[
            'Quiero que te mueras','ojala te bajen','vete a la mierda',
            'andate a la ','Que te jodas','Que te cache un burro',
            'fuera mierda','Andate a la'
        ],
        'Así es la vida, tranquilidad no más'=>[
            'Tengo mucho trabajo',
            'Me falta dinero',
            'Nunca me han querido',
            'Todo me sale mal',
            'La vida es una aventura',
            'Las cosas han subido',
            'He desaprobado cursos',
            'Cursos desaprobados',
            'Me voy a volver loco',
            'Me gusta la psicóloga',
        ],
        
        
        
        'Hola qué tal como estás'=>['Hola','Hola como estas','Hi','Hello','Mucho gusto','Hey','Qué tal','buenos dias','buenas noches','buenas tardes'],
        'Mi nombre es TEVEL '=>['quien eres','Cómo te llamas','Cual es tu nombre','como te llaman'],
        'Ayudo al programa de tutoría psicológica'=>['Qué haces','Cuál es tu función','En que trabajas','Como funcionas'],
        'Mucho gusto'=>['soy un alumno','mi nombre es '],
        'Puedes revisar mis funciones, escribe el comando /ayuda'=>[
            'Necesito ayuda','como me puedes ayudar','que hago','como hago',
            'estoy perdido','me puedes ayudar','Apoyame ','orientame'],
        'Escribe el comando <B><style="color:blue;">/registro</style></B> y coloca tu código UNI,DNI y un curso de riesgo de la siguiente manera por ejemplo : <br> <b>19990117K@10201403@MC515</b>'=>[
            'Como puedo registrarme','que hago para registrarme',
            'como me registro','me quiero registrar', 'me quiero apuntar',
            'quiero meterme','necesito registrarme','quiero que me envien informacion',
            ],
        'Lo siento mucho soy un robot, y a veces fallo'=>[
            'no pasa nada contigo','no me sirves','No me ayudaste',
            'te falta mucho','pense que eras mas inteligente',
            'eres un fiasco','eres una estafa','no entiendes nada',
            'no aciertas','eres un aburrido'
            ],
        'Hasta luego'=>['chao','adios','hasta pronto','fue un gusto','te dejo',
            'hasta luego','hasta la vista','cuidate'
            ]
        
        
        ];
    
  public function mensaje_ayuda(){
      return 'Hola soy  <b><i>'.$this->nombre.'</i></b> fui creado para facilitar la comunicación con las personas del programa de Tutoría, ofreciendo respuestas a consultas básicas'
                         . ' y notificando algunas novedades.'.chr(10).chr(10).''
                         . '<b><u>Los siguientes comandos están disponibles:</u></b>  '.chr(10).chr(10)
                         .'     1) <b><u>Para todos:</u></b>'.chr(10).chr(10)
                         .'     /ayuda  : Te muestra el listado de todos los comandos disponibles. '.chr(10)
                         .'     /escape : Abandona la conversación, o cancela cualquier comando en el que te encuentres.'.chr(10)
                         .'     2) <b><u>Para alumnos:</u></b>'.chr(10).chr(10)
                         .'     /registro : Te afilia al grupo, verificando 3 datos CODIGO@DNI@CODCURSO '.chr(10)
                         .'     /eventos : Te muestra los eventos programados y te permite descargar el material .'.chr(10).chr(10)
                         .'     /recursos : Muestra los hipervínculos o archivos disponibles de interés general. Afiches,avisos, manuales o material de sesión.'.chr(10).chr(10)
                         .'     /citas : Muestra tus citas programadas a futuro.'.chr(10).chr(10)
                         .'     3) <b><u>Para usuarios del sistema:</u></b>'.chr(10).chr(10)
                         .'     /registro_usuario : Te afilia al grupo, verificando 2 datos NOMBREUSUARIO@HASH '.chr(10)
                         .'     /noticitashoy : Envía un recordatorio a todos los alumnos que tienen cita en el día'.chr(10)
                         .'     /notievento : Envía la información del eveto inmediato posterior a todos los alumnos'.chr(10)
                         .'     /comunicado : Envía un comunicado a todos los alumnos afiliados '.chr(10).chr(10)
                         .' Puedes también conversar conmigo, por ahora sólo respondo cosas básicas'.chr(10)
                          .'Además recibirás notificaciones cuando programen tu cita o de algún cambio o de un evento';
  }
    
   public function getUser(){
       if(is_null($this->_user)){
           $this->_user=$this->isRegistered();
       }
       return $this->_user;
   }
   public function getChatId(){
       return $this->input->message->chat->id;
   }
    
   /*//retiorna el modelo tallerdet
    public function getTallerdet(){
      if($model=$this->isRegistered(true)){
         $rows= (new \yii\db\Query())->from('{{%sta_talleresdet}}')->andWhere(['id'=>$model->tallerdet_id])->one();
          return $row[]
      }else{
          return null;
      }
    }*/
            
    public function isRegistered($returnmodel=true){
       $model= TlbotUsers::find()->andWhere([
            'chat_id'=>$this->chatId,
            'activo'=>'1'           
        ])->one();
       if(is_null($model))return false;
       return ($returnmodel)?$model:true;
    }
    
    
    public function cmdCitas(){
         // $texto=$this->input->message->text; 
        // $ultimoPaso=$this->lastStep;         
        // $paso=$ultimoPaso->paso;
        // $sticker=false;
        // $tallerdet=$this->user->tallerdet;
        $cad='';
       
           $rows= (new \yii\db\Query())->from('{{%sta_citas}}')->
                   andWhere(['talleresdet_id'=>$this->user->tallerdet_id,'activo'=>'1','justificada'=>'0'])
                   ->andWhere(['>','fechaprog',date('Y-m-d h:i:s')])
                   ->all();
            if(count($rows)>0){
                $cad='<b><u>Se encontraron las siguientes citas programadas para tí:</u></b>'.chr(10);
               
                foreach($rows as $cita){
                     $proceso= \frontend\modules\sta\models\StaFlujo::find()->select(['proceso'])->andWhere(['id'=>$cita['flujo_id']])->scalar();
                
                    $cad.='El día '.Alumnos::SwichtFormatDate($cita['fechaprog'], Alumnos::_FDATETIME, true).' - '.$proceso.chr(10);
                }
            }else{
                $cad='No se encontraron citas programas para tí a futuro. Recibirás una notificación en cuanto se programen.';
            }
           $cad.=chr(10).'Puedes tener el enlace a la reunión, mediante el comando /recursos. ';
            return $this->sendMessage([
                        'chat_id' =>$this->chatId,
                        'text' => $cad,
                        'parse_mode'=>'HTML'
                            ]); 
        
         die();
     }
    
    
    
    public static function detectaGroseria($texto){
        $texto= strtolower($texto);
        $es_lisura=false;
        foreach(self::$lisuras as $key=>$lisura){
            if (!(strpos($texto, $lisura) === false)){
             $es_lisura=true;
              break;
            } 
        }
        return $es_lisura;
    }
    
    
    public static function respuesta($frase){
        if(static::detectaGroseria($frase)) return '¿Me estás hablando de tu personalidad, o me parece?';
        $encontro=false;
        foreach(self::$posibles_respuestas as $respuesta=>$posibles_frases_alumno){
           foreach($posibles_frases_alumno as $key=> $posible_frase_alumno){
               similar_text(strtolower($frase), strtolower($posible_frase_alumno), $percent);
                 //yii::error('frase => '.$frase.' : Posible frase=> '.$posible_frase_alumno.' porcentaje :'.$percent);
                   if($percent >=60){
                       $encontro=true;
                       $responder=$respuesta;
                       break;
                   }
               }
              if($encontro)break; 
            
        }
        return ($encontro)?$responder:'No entendí. Mejor prueba los comandos, escribe /ayuda';
    }
    
    public function mapCommand(){
        
    }
            
     public function cmdClearComando(){
         $this->removeSesion();
          $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                        'text' => 'Saliste del Comando',
                        //'parse_mode'=>'html'
                            ]); 
     }
     public function cmdRevokeUser(){
         
     }
     
     public function cmdAyuda(){
           $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                        'text' => $this->mensaje_ayuda(),
             //'disable_web_page_preview' => true,
                       'parse_mode'=>'HTML'
                            ]); 
           $this->removeSesion();
     }
     
     private function isComando($text){
         
         return (substr($text,0,1)=='/' && array_key_exists(substr($text,1),self::$map_comandos));
     }
     
     public function cmdRegistroAlumno(){
          $texto=$this->input->message->text; 
         $ultimoPaso=$this->lastStep;
         $sticker=false;
         $paso=$ultimoPaso->paso;
         /*
          * Si ya esta registrado no hacer nada 
          */
         if($this->hasRegistered()){
             $this->sendMessage([
                        'chat_id' =>$this->chatId,
                        'text' => 'Esta cuenta ya está registrada, no necesitas hacer esto',
                        'parse_mode'=>'HTML'
                            ]); 
             $this->removeSesion();
             return;
         }
         
         if($this->isComando($texto)){
             
         }
         if($paso==1){
             yii::error('Es el primer paso',__FUNCTION__);
             //REGISTRAR EL SEGUNDO PASO PERO CON FINAL FALSE, ABIERTO 
             yii::error('Aumentando un paso,antes de enviar el mensaje',__FUNCTION__);
             $this->registraPasoInSesion($ultimoPaso->comando,2,false);
             
             $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                        'text' => 'Coloca tu <u><b>código UNI</b></u>, <u><b>número DNI</b></u> y <u><b>código de un curso de riesgo</b></u>, que estés llevando separados por el caracter "<b><i>@</i></b>", de la siguiente manera, por ejemplo : <b><i>19990117K</i></b>@<b><i>10201403</i></b>@<b><i>MC515</i></b>',
                        'parse_mode'=>'HTML'
                            ]); 
             return ;
         }else{//Si ha contestado
             $final=false;
             yii::error('NO Es el primer paso',__FUNCTION__);
         $datos_ingresados=explode("@",$texto);
         
         if(!(count($datos_ingresados)==3)){
          //DATO MAL ESCRITO  
             $final=false;
            $mensaje_final='No están completos los datos solicitados. Recuerda el formato es:<b>CODIGOUNI@DNI@CODIGOCURSO</b>';
            $this->registraPasoInSesion($ultimoPaso->comando,2,$final);
         }else{
            $validator = new RegularExpressionValidator(['pattern'=> h::gsetting('sta', 'regexcodalu')]);
              if($validator->validate($datos_ingresados[0])) {
                            $validator->pattern=h::gsetting('general', 'formatoDNI');
                  if($validator->validate($datos_ingresados[1])){
                      //hallando el alumno
                      if(!is_null($modelAlu=Alumnos::find()->andWhere(['codalu'=>$datos_ingresados[0],'dni'=>$datos_ingresados[1]])->one())){
                            //hallnado el riesgo
                          yii::error((new \yii\db\Query())->select('id')->from('{{%sta_aluriesgo}}')->andWhere(['codalu'=>$datos_ingresados[0],'codcur'=>$datos_ingresados[2],  'codperiodo'=>staModule::getCurrentperiod()])->andWhere(['<>','status','R'])->createCommand()->rawSql);
                         
                          if((new \yii\db\Query())->select('id')->from('{{%sta_aluriesgo}}')->where(['codalu'=>$datos_ingresados[0],'codcur'=>$datos_ingresados[2],  'codperiodo'=>staModule::getCurrentperiod()])->andWhere(['<>','status','R'])->exists()){
                                 $idsTalleres=(new \yii\db\Query())->select('id')->from('{{%sta_talleres}}')->andWhere(['codperiodo'=>staModule::getCurrentperiod()])->column();
                                   $row=(new \yii\db\Query())->from('{{%sta_talleresdet}}')->andWhere(['codalu'=>$datos_ingresados[0],'talleres_id'=>$idsTalleres])->one();
                                  if(!($row===false)){
                                      if(!is_null($model=TlbotUsers::find()->andWhere(['chat_id'=>$this->input->message->chat->id])->one())){
                                           if($model->chat_id==$this->input->message->chat->id){
                                                $mensaje_final=$modelAlu->nombres.' Ya figuran estos datos, ya estás, registrado, y usaste este mismo equipo móvil para esto';
                                            
                                           }else{
                                              $mensaje_final=$modelAlu->nombres.' Ya aparece un registro para estos datos, y se hizo con otro número de móvil, ponte en contacto con el personal de Tutoría';
                                   
                                           }
                                            
                                      }else{
                                           $modelito=New  TlbotUsers();
                                            $modelito->setAttributes([
                                                            'chat_id'=>$this->input->message->chat->id,
                                                             'user_id'=>-1,
                                                            'tallerdet_id'=>$row['id'],
                                                            'codfac'=>$row['codfac'],
                                                            'activo'=>true,
                                                            'role'=>self::LEVEL_ALU,
                                                            'cuando'=>date(\common\helpers\timeHelper::formatMysqlDateTime()),             
                                                            ]);
                                               if($modelito->save()){
                                                   $final=true;
                                                   $sticker=true;
                                                    $mensaje_final='¡ Excelente  '.$modelAlu->nombres.',tus datos fueron verificados y te acabas de registrar tu número, en el grupo de riesgo';
                                 
                                               }else{
                                                   $mensaje_final='Hubo un error '.$modelito->getFirstError();
                                 
                                               }
                                            }
                                   
                                           }else{
                                       //NO ESTA DENTRO DEL PROGRAMA                                        
                                        $mensaje_final='Tus datos son correctos,estás en la lista de riesgo, pero no estás dentro de tutoría, es posible que no te hayan agregado aún';
                                   }
                                 
                             }else{
                               //no encontro alu riesgo 
                                  $mensaje_final='No figuras en la lista de riesgo, por favor verifica o consulta';
                             }
                          
                      }else{
                        //no encontro alumno uni  
                           $mensaje_final='Código UNI no encontrado para este DNI';
                      }
                      
                                
                   }else{
                     //DNI MAL ESCRITO
                       $mensaje_final='Me parece que no has escrito bien el DNI';
                   }
                } else{
                    //CODIGO UNI MAL ESCRITO
                   $mensaje_final='Creo que a tu código UNI le falta algo';
                }
           $this->registraPasoInSesion($ultimoPaso->comando,2,$final);
         }
             $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                        'text' =>$mensaje_final,
                        'parse_mode'=>'html'
                            ]);
              if($final){
                  if($sticker)$this->sendSticker([
                        'chat_id' =>$this->input->message->chat->id,
                        'sticker' =>'CAACAgIAAxkBAAEC44RhPSh7nImDAXDn9SXFD39Hx1c9kQACawAD9wLIDz5Tx-w4H5rTIAQ',
                        //'parse_mode'=>'html'
                            ]);
                  $this->removeSesion();
              }else{
                  if($intentos=$this->countIntentos()>3){               
                      
                      $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                        'text' =>$this->chatForIntentos($intentos),
                        //'parse_mode'=>'html'
                            ]);
                  }
              }
             
            die();
            
         }
     }
     
     public static function freeChat(){
         
     }
     
     private function isTheSameCommand($comando){
         $sesion=h::session();
         $chatId=$this->input->message->chat->id;
         $comando=(substr($comando,0,1)=='/')?$comando:susbtr($comando,1);
         if($sesion->has($chatId.'_'.$comando)){
             return ($sesion[$chatId.'_'.$comando]['comando']==$comando);
         }else{
             return false;
         }
     }
     /*
      * Si el hook està en el modo conversacion tu a tu 
      */
     public function isInDuoChat($chat_id=null){
         if(is_null($chat_id)){
           $chat_id= $this->chatId; 
         }
         $mn=TlbotHooks::find()->andWhere([
             'esfinal'=>'0',
             'comando'=>'inichat',
             'chat_id'=>$chat_id,
         ])->orWhere([
             'esfinal'=>'0',
             'comando'=>'inichat',
             'chat_id_recept'=>$chat_id,
               ])->one();
         return (is_null($mn))?false:$mn;
         //return ($this->lastStep->nChats()>0);
     }
     
    
     
     public function interpretaComandos(){
          $texto=$this->input->message->text;
          /*if($hookInitial=$this->isInDuoChat()){
              \yii::error('Esta en duop Chat ',__FUNCTION__);
               // $chat_id_a_donde_enviar  depende de quien hookee
               if($hookInitial->chat_id==$this->chatId){//Si es el que inicio el chat, debe de enviarse al que acepto el chat
                 $chat_id_a_donde_enviar=$hookInitial->chat_id_recept;
                 $direccion=0;
               }else{//si es el que acepto el chat, hay que enviarle al que inicio el chat
                  $chat_id_a_donde_enviar=$hookInitial->chat_id;  
                  $direccion=1;
               }
               
                 $this->sendMessage([
                        'chat_id' =>$chat_id_a_donde_enviar,
                            'text' =>$texto,
               //'parse_mode'=>'HTML'
                            ]);
                
                return $this->insertChat($hookInitial->id,$this->chatId,$chat_id_a_donde_enviar,$direccion);
          }
          */
         
          
         if($lastStep=$this->lastStep){//Si ya hubo un paso anterior  
                      //yii::error('Hubo un paso anterior ',__FUNCTION__);
                  if(!$this->isStepNew){
                      //yii::error('Pero este paso  es continuacion  ',__FUNCTION__);
                      //Si este paso es nuevo
                     //yii::error('el comando del paso anterior es '.$lastStep->comando,__FUNCTION__);
                       //yii::error('lamfucion a ejecutar es ->'.self::$map_comandos[$lastStep->comando]['funcion'],__FUNCTION__);
                     return   $this->{self::$map_comandos[$lastStep->comando]['funcion']}();
                  
                     } else{
                      // yii::error('Este paso no es continuacion  ',__FUNCTION__);
                       /*
                        * Si esta en modo chart avisarle que 
                        * ha expirado el chat por tiempo
                        */
                       if($hook=$this->isInDuoChat()){
                           $mensaje='La conversación ha terminado por tiempo de inactividad';
                           /* Al receptor */
                             $this->sendMessage([
                         'chat_id' =>$hook->chat_id_recept,
                            'text' => $mensaje,
               //'parse_mode'=>'HTML'
                            ]); 
                             
                          /*Al emisor*/
                             $this->insertChat($hook->id, $hook->chat_id, $hook->chat_id_recept,0, $mensaje);
                          $this->removeSesion();
                            return; 
                       }
                       
                       $this->removeSesion();
                       
                     //Si este paso no es nuevo es continuacion
                     if($this->isComando($texto)){
                         //yii::error('Se ingreso un comando ',__FUNCTION__);
                          //yii::error('Iniciando sesion ',__FUNCTION__);
                         $this->iniciaSesion($texto);
                          //yii::error('ejecutando la funcion ',__FUNCTION__);
                        return  $this->{self::$map_comandos[$lastStep->comando]['funcion']}();
                     } else{
                          //yii::error('no se ingreso un comando ',__FUNCTION__);
                        return   $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                            'text' => $this->respuesta($texto),
               //'parse_mode'=>'HTML'
                            ]);
                     }
                  }
             
         }else{//no hubo un paso anterior
             //yii::error('Nunca hubo un paso anteriro es la primera vez');
              if($this->isComando($texto)){
                  //yii::error('Es un comando ingresado');
                  //yii::error('Inixiando sexion');
                    $this->iniciaSesion($texto);
                    
                   return  $this->{self::$map_comandos[substr($texto,1)]['funcion']}();
                }else{
                    $this->removeSesion(); 
                    //yii::error('Enviando un mensaje tonto');
                      return   $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                            'text' => $this->respuesta($texto),
               //'parse_mode'=>'HTML'
                            ]);
                } 
             
         }
            
          
            
          
            
     }
 private function creaSesionSiNoExiste($comando){
         $sesion=h::session();
         $chatId=$this->input->message->chat->id;
         $comando=(substr($comando,0,1)=='/')?$comando:susbtr($comando,1);
         
         if(!$sesion->has($chatId.'_'.$comando)){
             $arreglo=[
             'chat_id'=>$chatId,
              'comando'=>$comando,
              'step'=>1,
             ];
            $sesion->set($chatId.'_'.$comando,$arreglo);
         }
     
     }
     
 private function sesionNextStep($comando){
   $sesion=h::session();
   $chatId=$this->input->message->chat->id;
         $comando=(substr($comando,0,1)=='/')?$comando:susbtr($comando,1);
   if($sesion->has($chatId.'_'.$comando)){
       $paso_actual=$sesion[$chatId.'_'.$comando]['step'];
       if((int)$paso_actual < (int)self::$map_comandos[$comando]['pasos']){
          $sesion[$chatId.'_'.$comando]=[
                      'chat_id'=>$chatId,
                        'comando'=>$comando,
                        'step'=>$paso_actual+1,
                        ]; 
       }
    }
  }
  
  public function isLastStep($comando){
      $sesion=h::session();
        $chatId=$this->input->message->chat->id;
         $comando=(substr($comando,0,1)=='/')?$comando:susbtr($comando,1);
        if($sesion->has($chatId.'_'.$comando)){
       $paso_actual=$sesion[$chatId.'_'.$comando]['step'];
       if((int)$paso_actual < (int)self::$map_comandos[$comando]['pasos']){
           return false;
       }else{
           return true;
       }
    }else{
        return true;//si no hay sesion es comando de paso unico por lo tanto es true
    } 
  }
  
  
  public function getNameSesion(){
      return 'ses_'.$this->input->message->chat->id.'sjyre854xyw6wy7';
  }
  
  public function getSesion(){
      if($this->_sesion==null){
          $this->_sesion=\Yii::$app->session;
      }
      return $this->_sesion;
  }
  
  public function sanitizeCommand($comando){
      
     if(substr($comando,0,1)=='/'){
         return substr($comando,1);
     }else{
         return $comando;
     }
         
  }
  /*public function iniciaSesion($comando,$unique=true){
      $final=($unique)?true:false;
      //$final=false;//siempre sera false al crear
      $valores=[$this->sanitizeCommand($comando), time(),1,$final];
      $this->sesion->set($this->nameSesion,[array_combine($this->campos_sesion,$valores)]);
  }*/
  
  public function iniciaSesion($comando,$unique=true){
      $final=($unique)?true:false;
      $model=new TlbotHooks();
      $model->setAttributes([
                  'comando'=>$this->sanitizeCommand($comando),
                  'chat_id'=>$this->input->message->chat->id,
                  'time'=> time(),
                  'paso'=> 1,
                  'esfinal'=>$final,
              ]);
      if(!$model->save())\yii::error($model->getFirstError(),__FUNCTION__);
   }
  
  
  /*public function registraPasoInSesion($comando,$step,$esfinal=true){
      $array_completo=$this->sesion[$this->nameSesion];
      $valores=[$this->sanitizeCommand($comando), time(),$step,$esfinal];
      $array_completo[]=array_combine($this->campos_sesion,$valores);
      $this->sesion->set($this->nameSesion,$array_completo);  
  }*/
  
  public function registraPasoInSesion($comando,$step,$esfinal=true){
      (new TlbotHooks(
              [
                  'comando'=>$this->sanitizeCommand($comando),
                  'chat_id'=>$this->input->message->chat->id,
                  'time'=> time(),
                  'paso'=> $step,
                  'esfinal'=>$esfinal,
              ]))->save(); 
  }
  
  /*public function removeSesion(){
    if($this->sesion->has($this->nameSesion))$this->sesion->remove($this->nameSesion);  
  }*/
  public function removeSesion(){
     TlbotHooks::deleteAll(['chat_id'=>$this->input->message->chat->id]);
    TlbotMessages::deleteAll(['chat_id_sender'=>$this->input->message->chat->id]);
    TlbotMessages::deleteAll(['chat_id_recept'=>$this->input->message->chat->id]);
     }
  
  /*public function getLastStep(){
     if(!$this->sesion->has($this->nameSesion))return false;
     
      $arraysesion=$this->sesion->get($this->nameSesion);
     
     return end($arraysesion);      
  }*/
  public function getLastStep(){
     $maxId= TlbotHooks::find()->select(['max(id)'])->
       andWhere(['chat_id'=>$this->input->message->chat->id])
              ->scalar();
     if($maxId===false)return false;
     return TlbotHooks::findOne($maxId);
           
  }
  
  /*public function getIsStepNew(){
      if(!$this->lastStep)return true;
      $tiempopasado=time()-$this->lastStep['time'];
      return ($tiempopasado > 60 or $this->lastSesion['esfinal']);
      
  }*/
  public function getIsStepNew(){
      $ultimoregistro=$this->lastStep;
      if($ultimoregistro===false)return true;
      
      
      $tiempopasado=time()-$ultimoregistro->time;
      return ($tiempopasado > 1500 or $ultimoregistro->esfinal);
      
  }
  
  
  public function emoji($utf8emoji) {
    preg_replace_callback(
        '@\\\x([0-9a-fA-F]{2})@x',
        function ($captures) {
            return chr(hexdec($captures[1]));
        },
        $utf8emoji
    );

    return $utf8emoji;
   }
   
   
  public function htmlText($texto){
      $cadena=$texto;
     /* if($posicion= strpos(strtolower($texto), 'http://')){
          
      }
      $i=0;
      do{
         $caracter= 
           $i++;
        }while($i=23);
      
        if($posicion= strpos($texto, 'http://')){
            if($posicion2=strpos(substr($texto,$posicion), ' ')){
                $posicion2+=$posicion+1;
                $cadena=substr($texto,0,$posicion-1).'<a href="'.
                        substr($texto,$posicion,$posicion2-$posicion-1).
                        '">'.substr($texto,$posicion,$posicion2-$posicion-1).'</a>'.
                        substr($texto,$posicion2-1);
            }else{
               $cadena=substr($texto,0,$posicion-1).'<a href="'.
                        substr($texto,$posicion).
                        '">'.substr($texto,$posicion).'</a>';
            }
        
        } elseif($posicion= strpos($texto, 'https://')){
            
            if($posicion2=strpos(substr($texto,$posicion), ' ')){
                $posicion2+=$posicion+1;
                $cadena=substr($texto,0,$posicion-1).'<a href="'.
                        substr($texto,$posicion,$posicion2-$posicion-1).
                        '">'.substr($texto,$posicion,$posicion2-$posicion-1).'</a>'.
                        substr($texto,$posicion2-1);
            }else{
               $cadena=substr($texto,0,$posicion-1).'<a href="'.
                        substr($texto,$posicion).
                        '">'.substr($texto,$posicion).'</a>';
            }
            
          
        } elseif($posicion= strpos($texto, 'HTTPS://')){
            if($posicion2=strpos(substr($texto,$posicion), ' ')){
                $posicion2+=$posicion+1;
                $cadena=substr($texto,0,$posicion-1).'<a href="'.
                        substr($texto,$posicion,$posicion2-$posicion-1).
                        '">'.substr($texto,$posicion,$posicion2-$posicion-1).'</a>'.
                        substr($texto,$posicion2-1);
            }else{
               $cadena=substr($texto,0,$posicion-1).'<a href="'.
                        substr($texto,$posicion).
                        '">'.substr($texto,$posicion).'</a>';
            }
            
        }elseif($posicion= strpos($texto, 'HTTP://')){
            if($posicion2=strpos(substr($texto,$posicion), ' ')){
                $posicion2+=$posicion+1;
                $cadena=substr($texto,0,$posicion-1).'<a href="'.
                        substr($texto,$posicion,$posicion2-$posicion-1).
                        '">'.substr($texto,$posicion,$posicion2-$posicion-1).'</a>'.
                        substr($texto,$posicion2-1);
            }else{
               $cadena=substr($texto,0,$posicion-1).'<a href="'.
                        substr($texto,$posicion).
                        '">'.substr($texto,$posicion).'</a>';
            }
        }*/
      return html_entity_decode((strip_tags($cadena,$this->_preserveHtmlTags)));
      
  }
  
  
  public function iniChat($chat_id,$chat_id_recept,$msg,$direc=0){
      $modelo=New \common\models\TlbotHooks();
      $modelo->setAttributes([
          'comando'=>'inichat',
          'time'=>time(),
          'chat_id'=>$chat_id,
          'chat_id_recept'=>$chat_id_recept,
          'paso'=>1,
          'esfinal'=>false,
          //'direction'=>0,
      ]);
      $GRABO=$modelo->save();
      if(!$GRABO)yii::error('NO grabo '.$modelo->getFirstError());
      $modelo->refresh();
      $mod=New \common\models\TlbotMessages();
      $mod->setAttributes([
          'hook_id'=>$modelo->id,
          'time'=>date("Y-m-d H:i:s", time() + 1),
          'chat_id_sender'=>$chat_id,
          'chat_id_recept'=>$chat_id_recept,
          'activo'=>true,
          'message'=>$msg,
          'direction'=>0,
      ]);
      $mod->save();
      $GRABO=$mod->save();
      if(!$GRABO)yii::error('NO grabo '.$mod->getFirstError());
       $this->sendMessage([
                        'chat_id' =>$chat_id_recept,
                        'text' => 'Se ha iniciado conversación con una persona->'.self::prefijoChat().$msg,
                        'parse_mode'=>'HTML'
                            ]); 
      return $mod->save();
  }
  
  public function insertChat($hook_id,$chat_id_sender,$chat_id_recept,$direccion,$texto=null){
      $mod=New \common\models\TlbotMessages();
      $mod->setAttributes([
          'hook_id'=>$hook_id,
          'time'=>date("Y-m-d H:i:s", time() + 1),
          'chat_id_sender'=>$chat_id_sender,
          'chat_id_recept'=>$chat_id_recept,
          'activo'=>true,
          'message'=>(!is_null($texto))?$texto:$this->input->message->text,
          'direction'=>$direccion,
      ]);
      //$mod->direccion=($mod->hook->chat_id==$this->chatId)?0:1;
      return $mod->save();
  }
  
  public function getChatIdUser(){
     if(is_null($model= TlbotUsers::find()
              ->andWhere(
             [
                 'user_id'=>h::userId(),
             ])->one())){
         return null;
     }else{
         return $model->chat_id;
     }
  }
  
  /*
   * Chat id del que inicia la conversacion
   */
  public function getAllMessagesForChatId($chat_id,$chat_id_destino){
     
     if(!is_null($model=\common\models\TlbotHooks::find()->andWhere(
              ['chat_id'=>$chat_id, 'esfinal'=>0,'chat_id_recept'=>$chat_id_destino]
              )->andWhere(['>','chat_id_recept',0])->one())){
       
           return \common\models\TlbotMessages::find()->select(['time', 'chat_id_sender as client_chat_id','message', 'direction'])
            ->andWhere(
                    ['hook_id'=>$model->id,'activo'=>'1'] 
                    )->asArray()->all();
         
        }else{
           return false;
        }
     }

   public function countIntentos(){
       if($step=$this->lastStep){
           $intentos=TlbotHooks::find()->andWhere([
               'chat_id'=>$this->chatId,
                'esfinal'=>'0',
           ])->count();
           return $intentos;
       }else{
          return 0; 
       }
   }
   
   public function chatForIntentos($intentos){
       $messages=[
                'suaves'=>[
                            'Revisa lo que has escrito, e inténtalo nuevamente, mira el mensaje de arriba',
                            'Hay algo que no estás ingresando bien, mira el mensaje de arriba',
                            'Lee cuidadosamente la ayuda del comando que estás ejecutando, ya van varios intentos'
                          ],
                 'medios'=>[
                            'No insistas tanto, mejor presta atención al mensaje de arriba',
                            'A todos nos falta el tiempo, así que revisa nuevamente, mira el mensaje de arriba',
                            'Es mejor ya no insistir, revisa tus datos, mira el mensaje de arriba',
                            'Qué crees que está fallando, ya lo estás intentando varias veces, mira el mensaje de arriba',
                             ],
               'fuertes'=>[
                            'Ahora sí, el gato al teclado, mejor presta atención al mensaje de arriba',
                            '¿Te encanta perder tiempo verdad?. Así que revisa nuevamente, mira el mensaje de arriba',
                            'Tengo harta paciencia, pero tengo que atender a otros, por favor revisa tus datos, mira el mensaje de arriba',
                            'A mi nada me cuesta responderte todo el día, ya lo estás intentando varias veces, mira el mensaje de arriba',
                             ],
           
       ];
       if($intentos >=2 and $intentos < 5){
           return $messages['suaves'][random_int(0, 2)];
       }elseif($intentos >=5 and $intentos < 9){
           return $messages['medios'][random_int(0, 3)];
       }elseif($intentos >=5 ) {  
           return $messages['fuertes'][random_int(0, 3)];
       }else{
           return 'hola';
       }
      
   }
   
   public function hasRegistered(){
      return (!is_null(TlbotUsers::find()->
              andWhere(['chat_id'=>$this->chatId])->one()));
                                           
   }
   
    public function cmdRegistroUsuario(){
          $texto=$this->input->message->text; 
         $ultimoPaso=$this->lastStep;
         $sticker=false;
         $paso=$ultimoPaso->paso;
         /*
          * Si ya esta registrado no hacer nada 
          */
         if($this->hasRegistered()){
             $this->sendMessage([
                        'chat_id' =>$this->chatId,
                        'text' => 'Esta cuenta ya está registrada, no necesitas hacer esto',
                        'parse_mode'=>'HTML'
                            ]); 
             $this->removeSesion();
             return;
         }
         
        
         if($paso==1){
             yii::error('Es el primer paso',__FUNCTION__);
             //REGISTRAR EL SEGUNDO PASO PERO CON FINAL FALSE, ABIERTO 
             yii::error('Aumentando un paso,antes de enviar el mensaje',__FUNCTION__);
             $this->registraPasoInSesion($ultimoPaso->comando,2,false);
             
             $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                        'text' => 'Para registrarte como usuario del sistema Coloca tu <u><b>cuenta de usuario</b></u>, <u><b>el hash</b></u> (Para obtener el hash, consúltalo en el profile del usuario), separados por el caracter @  de la siguiente manera, por ejemplo : <b><i>nombre_usuario</i></b>@<b><i>mi_hash</i></b>',
                        'parse_mode'=>'HTML'
                            ]); 
             return ;
         }else{//Si ha contestado
             $final=false;
             yii::error('NO Es el primer paso',__FUNCTION__);
         $datos_ingresados=explode("@",$texto);
         
         if(!(count($datos_ingresados)==2)){
          //DATO MAL ESCRITO  
             $final=false;
            $mensaje_final='Los datos ingresados no tienen el formato requerido. Recuerda el formato es:<b>nombreusuario@hash</b>';
            $this->registraPasoInSesion($ultimoPaso->comando,2,$final);
         }else{
            $validator = new RegularExpressionValidator(['pattern'=> '/^[\w]+$/']);
              if($validator->validate($datos_ingresados[0])) {
                           // $validator->pattern=h::gsetting('general', 'formatoDNI');
                  if($validator->validate($datos_ingresados[1])){
                      //hallando el alumno
                     if(is_null($model=\common\models\User::findByUsername($datos_ingresados[0]))){
                           $mensaje_final='No se encontró el usuario ';
                     }else{
                         if(!(strtolower($model->profile->hash)==strtolower($datos_ingresados[1]))){
                            $mensaje_final='El hash no coincide '; 
                         }else{
                              $codfac=null;
                                    if(!is_null($re=\frontend\modules\sta\models\UserFacultades::find()->andWhere(['user_id'=>$model->id,'activa'=>'1'])->one())){
                                       $codfac=$re->codfac; 
                                    }
                                       $modelito=New  TlbotUsers();
                                            $modelito->setAttributes([
                                                            'chat_id'=>$this->input->message->chat->id,
                                                             'user_id'=>$model->id,
                                                            'tallerdet_id'=>0,
                                                            'codfac'=>$codfac,
                                                            'role'=>self::LEVEL_ADMIN,
                                                            'activo'=>true,
                                                            'cuando'=>date(\common\helpers\timeHelper::formatMysqlDateTime()),             
                                                            ]);
                                               if($modelito->save()){
                                                   $final=true;
                                                   $sticker=true;
                                                    $mensaje_final='¡ Excelente  <b><i>'.$datos_ingresados[0].'</i></b>,tus datos fueron verificados y te acabas de registrar tu número, en el grupo de riesgo';
                                 
                                               }else{
                                                   $mensaje_final='Hubo un error '.$modelito->getFirstError();
                                 
                                                } 
                             }//no coinide el hash
                            
                         }//NO EXISTE USUARIO
                                
                   }else{
                     //User mal escrito
                      // $mensaje_final='El';
                       $mensaje_final='El hash ingresado no es el correcto';
                   }
                } else{
                    //CODIGO UNI MAL ESCRITO
                    //$mensaje_final='El';
                   $mensaje_final='El nombre de usuario está mal escrito';
                }
           $this->registraPasoInSesion($ultimoPaso->comando,2,$final);
         }
             $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                        'text' =>$mensaje_final,
                        'parse_mode'=>'html'
                            ]);
              if($final){
                  if($sticker)$this->sendSticker([
                        'chat_id' =>$this->input->message->chat->id,
                        'sticker' =>'CAACAgIAAxkBAAEC44RhPSh7nImDAXDn9SXFD39Hx1c9kQACawAD9wLIDz5Tx-w4H5rTIAQ',
                        //'parse_mode'=>'html'
                            ]);
                  $this->removeSesion();
              }/*else{
                  if($intentos=$this->countIntentos()>3){               
                      
                      $this->sendMessage([
                        'chat_id' =>$this->input->message->chat->id,
                        'text' =>$this->chatForIntentos($intentos),
                        //'parse_mode'=>'html'
                            ]);
                  }
              }*/
             
            die();
            
         }
     }
   
   public function isUser(){
       return is_null($this->user)?false:true;
   }
   /*
    * true: sigue adelante;
    * false: termina la ekjecucion
    */
   public function filterCommand(){
       yii::error('igersando a la funcion ',__FUNCTION__);
       $texto=$this->input->message->text;
        if($texto=='/escape'){
             yii::error('Limpiando ',__FUNCTION__);
            $this->removeSesion(); 
               $this->sendMessage([
                        'chat_id' =>$this->chatId,
                            'text' =>'Liberaste comandos anteriories, puedes ingresar un nuevo comando',
               //'parse_mode'=>'HTML'
                            ]);
            return false;
          }
          /*
           * Si hay un comnado dentro de otro comando
           */
        if($step=$this->lastStep){
            
            if(!$step->esfinal && $this->isComando($texto) 
                    && !$this->isStepNew)
                yii::error('Hayuncomando dentro de otro ',__FUNCTION__);
            if(!$step->comando==$this->sanitizeCommand($texto)) {//Si los comandos son diferentes
                
               $this->sendMessage([
                        'chat_id' =>$this->chatId,
                            'text' =>'Estás dentro un proceso del comando anterior '.$step->comando.' y no puedes ejecutar este comando nuevo. Puedes usar el comando /evadir para salir si lo deseas',
               //'parse_mode'=>'HTML'
                            ]);
               return false;    
            }
               
        }
        /*
         * Si el comando es libre pasa ok
         */
        if($this->isComando($texto)){
            if(self::$map_comandos[$this->sanitizeCommand($texto)]
                ['user_level'] == self::LEVEL_ANY ){
               return true;
           }
        }
           
       if($user=$this->user ){
           
            yii::error('es usuaroi ',__FUNCTION__);
           yii::error('es un suuario ',__FUNCTION__);
           yii::error($user->user_id,__FUNCTION__);
           //yii::error('veamos si son iguales',__FUNCTION__);
           /*yii::error(self::$map_comandos[$this->sanitizeCommand($texto)]
                       ['user_level'],__FUNCTION__);*/
          //yii::error($user->role,__FUNCTION__);
           if($this->isComando($texto)){
              if(!(self::$map_comandos[$this->sanitizeCommand($texto)]
                       ['user_level']==$user->role)){
                  yii::error('son diferentes');
                    $this->sendMessage([
                        'chat_id' =>$this->chatId,
                            'text' =>'No estás autorizado para ejecutar este comando ',
                                //'parse_mode'=>'HTML'
                            ]);
                            return false; 
              }                  
           }
           yii::error('Sipaso son iguales'); 
       }else{
           yii::error('no es un usuario ',__FUNCTION__);
           if($this->isComando($texto)){
                yii::error('ES COMANDO  ',__FUNCTION__);
                 yii::error(self::$map_comandos[$this->sanitizeCommand($texto)]['user_level'],__FUNCTION__);
              yii::error(self::LEVEL_ANY,__FUNCTION__);
                 if(!self::$map_comandos[$this->sanitizeCommand($texto)]['user_level']==self::LEVEL_ANY){
                    $this->sendMessage([
                        'chat_id' =>$this->chatId,
                            'text' =>'No estás autorizado para ejecutar este comando, necesitas ser registrado ',
                                //'parse_mode'=>'HTML'
                            ]);
                            return false;
                 }                  
           }
       }
        yii::error('retirnando true ',__FUNCTION__);
     return true;
   }
   
  
    public function cmdRecursos(){
         
         $ultimoPaso=$this->lastStep;
         
         $paso=$ultimoPaso->paso;
        
         if($paso==1){
              //$this->registraPasoInSesion($ultimoPaso->comando,2,false);
           //seledcc9onamos los ids de eventos 
             $idTaller= (new \yii\db\Query())->select('id')->from('{{%sta_talleres}}')->andWhere(['codfac'=>$this->user->codfac,'codperiodo'=>staModule::getCurrentperiod()])->scalar();
            if(!$idTaller===false){
                yii::error($idTaller);
                $cad='<b><u>Estos son los recursos disponibles:</u></b>'.chr(10).chr(10);
                    $recursos= \frontend\modules\sta\models\StaRecursos::find()->andWhere(['taller_id'=>$idTaller])->all();
                 $attachSesion=[];
                    if(count($recursos)>0){                         
                        foreach($recursos as $recurso){ 
                        if($recurso->tipo==$recurso::TYPE_LINK){
                             yii::error(' '.$recurso->enlace.' ');
                          $cad.=$recurso->descripcion.':'.chr(10).$this->htmlText(' -> '.$recurso->enlace.' ').chr(10).chr(10);
                           }else{
                            
                           if(count($recurso->files)>0)
                               yii::error($recurso->files);
                               yii::error(Html::a($recurso->descripcion,$recurso->files[0]->url));
                                $ruta=yii::getAlias('@temp').'/'.FileHelper::fileName($recurso->files[0]->path,true);
                                if(!is_file($ruta))copy($recurso->files[0]->path,$ruta);
                             $cad.=$recurso->descripcion.chr(10).Html::a('Descarga aquí ('. strtoupper(FileHelper::extensionFile($ruta)).')',Url::base(true).'/temp/'.FileHelper::fileName($recurso->files[0]->path,true)).chr(10).chr(10);
                          }
                        }//fin del for
                             
                        $cad.=chr(10).'<b>Suerte</b>';  
                   }else{
                     $cad='Aún no se han subido recursos. Lo puedes intentar luego.'.chr(10).'Saludos';  
                   }
                      
                
            }  else{
                $cad='No se encontró ningún programa de tutoría';
            }   
             yii::error($cad);
             $this->sendMessage([
                        'chat_id' =>$this->chatId,
                       'text'=>$cad,
                         'parse_mode'=>'HTML'
                            ]); 
             $this->removeSesion();
             return ;
         }
             
            die();
            
         }        
   
    public function cmdEventos(){
         
         $ultimoPaso=$this->lastStep;
         
         $paso=$ultimoPaso->paso;
        
         if($paso==1){
              //$this->registraPasoInSesion($ultimoPaso->comando,2,false);
           //seledcc9onamos los ids de eventos 
             $idTaller= (new \yii\db\Query())->select('id')->from('{{%sta_talleres}}')->andWhere(['codfac'=>$this->user->codfac,'codperiodo'=>staModule::getCurrentperiod()])->scalar();
            if(!$idTaller===false){
                $cad='<b><u>Las próximas tutorías grupales son:</u></b>'.chr(10).chr(10);
                    $ideventos= (new \yii\db\Query())->select('id')->from('{{%sta_eventos}}')->andWhere(['talleres_id'=>$idTaller])->column();
                    $sesiones= \frontend\modules\sta\models\StaEventosSesiones::find()->select(['id','fecha','tema','url'])->andWhere(['eventos_id'=>$ideventos])->andWhere(['>','fecha',date('Y-m-d H:i:s')])->orderBy(['fecha'=>SORT_ASC])->all();
                 $attachSesion=[];
                    if(count($sesiones)>0){
                         
                        foreach($sesiones as $sesion){ 
                        if($sesion->hasAttachments()){
                            yii::error('sesion id '.$sesion->id.' tiene atacchs');
                            foreach($sesion->files as $file){
                                $ruta=yii::getAlias('@temp').'/'.FileHelper::fileName($file->path,true);
                                  yii::error('La ruta origen : '.$file->path);
                                   yii::error('is file o no  : ');
                                   if(is_file($file->path)){
                                      yii::error('si lo es : '); 
                                   }else{
                                       yii::error('No  lo es : '); 
                                   }
                                   yii::error('La ruta dest : '.$ruta);
                                if(!is_file($ruta))
                                 copy($file->path,$ruta);
                                  $attachSesion[]='/temp/'.FileHelper::fileName($file->path,true);
                            }
                           
                        }else{
                              yii::error('sesion id '.$sesion->id.' NO tiene atacchs'); 
                            }
                      $cad.=$this->htmlText('<b>'.substr($sesion->fecha,0,16).' </b>-'.$sesion->tema.chr(10).'    Link de la reunión: '.$sesion->url.' '.chr(10));
                        $anexos='';
                      if(count($attachSesion)>0){
                            
                            $contador=1;
                            foreach($attachSesion as $key=>$ruta){
                                 $anexos.='    Link de descarga de material:'.Html::a('Descarga aquí ('. strtoupper(FileHelper::extensionFile($ruta)).')',Url::base(true).$ruta).' '.chr(10);  
                            }
                             yii::error('Los anexos son');
                            yii::error($anexos);
                        }
                      $cad.=$anexos.chr(10).chr(10);
                      $anexos='';
                     // $cad.=$this->htmlText('<b>'.substr($sesion->fecha,0,16).'-'.$sesion->tema.' </b>'.chr(10).'     '.$sesion->url.' ').chr(10).chr(10);
                      $attachSesion=[];
                            } 
                        $cad.=chr(10).'<b>Te esperamos</b>';  
                   }else{
                     $cad='Aún no se han programado tutorías grupales a futuro. Lo puedes intentar luego, o recibirás una notificación pronto.'.chr(10).'Saludos';  
                   }
                      
                
            }  else{
                $cad='No se encontró ningún programa de tutoría';
            }   
             yii::error('el mernsaje');
              yii::error($cad);
             $this->sendMessage([
                        'chat_id' =>$this->chatId,
                       'text'=>$cad,
                         'parse_mode'=>'HTML'
                            ]); 
             $this->removeSesion();
             return ;
         }
             
            die();
            
         }
    public function cmdNotiCitasHoy(){         
         $ultimoPaso=$this->lastStep;         
         $paso=$ultimoPaso->paso;        
         if($paso==1){
              //$this->registraPasoInSesion($ultimoPaso->comando,2,false);
           //seledcc9onamos los ids de eventos 
             $citas= (new \yii\db\Query())->select(['talleresdet_id','fechaprog'])->from('{{%sta_citas}}')->
                     andWhere(['>','fechaprog', date('Y-m-d H:i:s')])->
                     andWhere(['<','fechaprog', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'))->addHour(24)->format('Y-m-d H:i:s')])->
                     andWhere(['codfac'=>$this->user->codfac])->
                    all();
             yii::error((new \yii\db\Query())->select(['talleresdet_id','fechaprog'])->from('{{%sta_citas}}')->
                     andWhere(['>','fechaprog', date('Y-m-d H:i:s')])->
                     andWhere(['<','fechaprog', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'))->addHour(24)->format('Y-m-d H:i:s')])
                    ->andWhere(['codfac'=>$this->user->codfac])->createCommand()->rawSql);
            if(count($citas)>0){
                foreach($citas as $cita){
                   if(!is_null($user= TlbotUsers::find()->select(['chat_id'])->andWhere(['tallerdet_id'=>$cita['talleresdet_id']])->one())){
                     $this->sendMessage([
                        'chat_id' =>$user->chat_id,
                         'text'=>'Estimado Alumno, tienes una cita programada para el '.$cita->fechaprog,
                         'parse_mode'=>'HTML'
                            ]); 
                    
                
                  }
                  
                 }//
                 $this->sendMessage([
                        'chat_id' =>$this->chatId,
                         'text'=>'Se notificaron las citas de ahora a 24 horas a futuro.',
                         'parse_mode'=>'HTML'
                            ]); 
             }else{//si no hay citas 
                  $this->sendMessage([
                        'chat_id' =>$this->chatId,
                         'text'=>'No se encontraron citas programadas para notificar.',
                         'parse_mode'=>'HTML'
                            ]); 
             }
          $this->removeSesion();
                  
          } //apso 1
    }
    public function cmdNotiEvento(){ 
         $ultimoPaso=$this->lastStep;
         $paso=$ultimoPaso->paso;
         $cad='g ';
         $contador=0;
         if($paso==1){
           $idTaller= (new \yii\db\Query())->select('id')->from('{{%sta_talleres}}')->andWhere(['codfac'=>$this->user->codfac,'codperiodo'=>staModule::getCurrentperiod()])->scalar();
            if(!$idTaller===false){
                
                    $ideventos= (new \yii\db\Query())->select('id')->from('{{%sta_eventos}}')->andWhere(['talleres_id'=>$idTaller])->column();
                    $sesion= \frontend\modules\sta\models\StaEventosSesiones::find()->select(['id','fecha','tema','url'])->andWhere(['eventos_id'=>$ideventos])->andWhere(['>','fecha',date('Y-m-d H:i:s')])->orderBy(['fecha'=>SORT_ASC])->one();
                 $attachSesion=[];
                    if(!is_null($sesion)){
                        $cad='<b><u>Estimado alumno, hay un taller grupal programado:</u></b>'.chr(10).chr(10);
                        if($sesion->hasAttachments()){
                            yii::error('sesion id '.$sesion->id.' tiene atacchs');
                            foreach($sesion->files as $file){
                                $ruta=yii::getAlias('@temp').'/'.FileHelper::fileName($file->path,true);
                                  yii::error('La ruta origen : '.$file->path);
                                   yii::error('is file o no  : ');
                                   if(is_file($file->path)){
                                      yii::error('si lo es : '); 
                                   }else{
                                       yii::error('No  lo es : '); 
                                   }
                                   yii::error('La ruta dest : '.$ruta);
                                if(!is_file($ruta))
                                 copy($file->path,$ruta);
                                  $attachSesion[]='/temp/'.FileHelper::fileName($file->path,true);
                            }
                           
                        }else{
                              yii::error('sesion id '.$sesion->id.' NO tiene atacchs'); 
                            }
                      $cad.=$this->htmlText('<b>'.substr($sesion->fecha,0,16).' </b>-'.$sesion->tema.chr(10).'    Link de la reunión: '.$sesion->url.' '.chr(10));
                        $anexos='';
                      if(count($attachSesion)>0){
                            
                            
                            foreach($attachSesion as $key=>$ruta){
                                 $anexos.='    Link de descarga de material:'.Html::a('Descarga aquí ('. strtoupper(FileHelper::extensionFile($ruta)).')',Url::base(true).$ruta).' '.chr(10);  
                            }
                             yii::error('Los anexos son');
                            yii::error($anexos);
                        }
                      $cad.=$anexos.chr(10).chr(10);
                      $cad.=chr(10).'<b>Te esperamos</b>';  
                                $anexos='';
                     // $cad.=$this->htmlText('<b>'.substr($sesion->fecha,0,16).'-'.$sesion->tema.' </b>'.chr(10).'     '.$sesion->url.' ').chr(10).chr(10);
                                $attachSesion=[];
                         $IdChats= TlbotUsers::find()->select(['chat_id'])->andWhere(['codfac'=>$this->user->codfac,'activo'=>'1','role'=>self::LEVEL_ALU])->column();
                          $contador=0;
                         foreach($IdChats as $key=>$chat_id){
                               $this->sendMessage([
                                'chat_id' =>$this->chatId,
                                'text'=>$cad,
                                'parse_mode'=>'HTML'
                                ]); 
                              $contador++; 
                          }
                         // $cad='Se envió la notificación '.($contador==0)?'':' A '.$contador.'  alumnos';
                      }else{
                        $cad='No se encontraron registros para el envío';  
                      } 
                        
                  }else{
                      $cad='No se encontraron registros para el envío';
                  }
         }
             
             $this->sendMessage([
                        'chat_id' =>$this->chatId,
                       'text'=>$cad,
                         'parse_mode'=>'HTML'
                            ]); 
             $this->removeSesion();
             return ;
 }
         
 
 
 public function cmdSaludo(){
     $this->sendSticker([
                        'chat_id' =>$this->input->message->chat->id,
                        'sticker' =>'CAACAgEAAxkBAAEC6IxhQhf5uGCN-7PwbNbVUsqxYwW7WwACVTMAAtpxZgdUSKRTBteYgSAE',
                        
                            ]);
      $this->sendMessage([
                        'chat_id' =>$this->chatId,
                       'text'=>$this->htmlText($this->mensaje_ayuda()), 
                        'parse_mode'=>'html'
                       ]);
             $this->removeSesion();
             die();
             
             return ;
 } 
 
 
 public function msgMasivo($mensaje){
     $users=TlbotUsers::find()->select(['chat_id'])->andWhere(['role'=>'1'])->all();
     foreach($users as $user){
         $this->sendMessage([
                        'chat_id' =>$user->chat_id,
                       'text'=>$mensaje, 
                       // 'parse_mode'=>'html'
                       ]);
     }
   }
   
   
 public function cmdChatea(){
   if($hook=$this->isInDuoChat())
    $this->insertChat($hook->id, $hook->chat_id, $hook->chat_id_recept, 1, $this->input->message->text);  
 }
 
 public static function prefijoChat(){
     return '<b><i>Tutoría '.h::userName().' escribió :</i></b>'.chr(10);
 }
 
}

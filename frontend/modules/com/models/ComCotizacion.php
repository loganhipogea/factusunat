<?php

namespace frontend\modules\com\models;
use common\models\masters\Centros;
use common\models\masters\Clipro;
use common\models\masters\Trabajadores;
use common\models\masters\Direcciones;
use common\helpers\h;
use common\models\masters\Contactos;
use common\models\audit\Activerecordlog as Log;
use common\behaviors\FileBehavior;
use Yii;

/**
 
 * @property Direcciones $nDirecc
 */
class ComCotizacion extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    const PREFIX_CACHE_CARGOS='xjsdkjdsk_cargos';
    const NUMERO_ITEMS_POR_PAGINA=30;
    public $femision1=null;
    public $monto1=null;
    public $dateorTimeFields=[
     'femision'=>self::_FDATE,
      'femision1'=>self::_FDATE,   
         ];
    
    public $prefijo='78';
    
    const ESTADO_ABIERTO='AB';
    const ESTADO_APROBADO='AP';
    const ESTADO_ANULADO='AN';

    
    public function isEditable(){
        return $this->estado==self::ESTADO_ABIERTO;
    }
    
    
    public static function tableName()
    {
        return '{{%com_cotizaciones}}';
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
             [['codmon', 'serie',
                 'femision','codtra','validez',
                 'codcli','codcli1',
                 'descripcion'], 'required'],
             [[
                 'monto','igv','version',
                 'filtro','punit','memoria','fpago','sumaopunit','codtra',
                 ], 'safe'],
            [['detalle_interno', 'detalle_externo'], 'string'],
            [['validez', 'n_direcc'], 'integer'],
            [['numero', 'codcli', 'codcli1', 'femision'], 'string', 'max' => 10],
            [['serie', 'codmon'], 'string', 'max' => 3],
            [['codsoc'], 'string', 'max' => 1],
            [['codcen'], 'string', 'max' => 5],
            [['estado'], 'string', 'max' => 2],
            [['descripcion'], 'string', 'max' => 80],
            [['codtra'], 'string', 'max' => 6],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
            [['codcli1'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codcli1' => 'codpro']],
            [['codcli'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codcli' => 'codpro']],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
            [['n_direcc'], 'exist', 'skipOnError' => true, 'targetClass' => Direcciones::className(), 'targetAttribute' => ['n_direcc' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero' => Yii::t('app', 'Numero'),
            'serie' => Yii::t('app', 'Serie'),
            'codsoc' => Yii::t('app', 'Codsoc'),
            'codcen' => Yii::t('app', 'Codcen'),
            'codcli' => Yii::t('app', 'Cliente'),
            'codcli1' => Yii::t('app', 'Cliente'),
            'estado' => Yii::t('app', 'Estado'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle_interno' => Yii::t('app', 'Detalle Interno'),
            'detalle_externo' => Yii::t('app', 'Detalle Externo'),
            'femision' => Yii::t('app', 'Fecha'),
            'validez' => Yii::t('app', 'Validez'),
            'codtra' => Yii::t('base.names', 'Responsable'),
            'n_direcc' => Yii::t('app', 'N Direcc'),
            'codmon' => Yii::t('app', 'Moneda'),
            'fpago' => Yii::t('app', 'Forma de pago'),
            'sumaopunit' => Yii::t('app', 'Modalidad'),
        ];
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|CentrosQuery
     */
    public function getCodcen0()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

     public function getSocio()
    {
        return $this->hasOne(Clipro::className(), ['codsoc' => 'codsoc']);
    }
    /**
     * Gets query for [[Codcli0]].
     *
     * @return \yii\db\ActiveQuery|CliproQuery
     */
    public function getCliente1()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codcli']);
    }

    /**
     * Gets query for [[Codcli10]].
     *
     * @return \yii\db\ActiveQuery|CliproQuery
     */
    public function getCliente2()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codcli1']);
    }

    /**
     * Gets query for [[Codtra0]].
     *
     * @return \yii\db\ActiveQuery|TrabajadoresQuery
     */
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * Gets query for [[ComDetcotis]].
     *
     * @return \yii\db\ActiveQuery|ComDetcotiQuery
     */
    public function getComDetcotis()
    {
        return $this->hasMany(ComDetcoti::className(), ['coti_id' => 'id']);
    }

    
    public function getPartidas()
    {
        return $this->hasMany(ComCotigrupos::className(), ['coti_id' => 'id']);
    }
    
     public function getCargos()
    {
        return $this->hasMany(ComCargoscoti::className(), ['coti_id' => 'id']);
    }
    
   public function getContactos(){
        return $this->hasMany(ComContactocoti::className(), ['coti_id' => 'id']);
    }
    
    
    public function getSubpartidas(){
        return $this->hasMany(ComCotiDet::className(), ['coti_id' => 'id']);
    }
    
    public function getVersiones(){
        return $this->hasMany(\frontend\modules\com\models\ComCotiversiones::className(), ['coti_id' => 'id']);
    }
    
    public function getEnvios(){
        return $this->hasMany(\frontend\modules\com\models\ComCotienvios::className(), ['coti_id' => 'id']);
    }
    
    public function getAdjuntos(){
        return $this->hasMany(\frontend\modules\com\models\ComCotiadjuntos::className(), ['coti_id' => 'id']);
    }
    /**
     * Gets query for [[NDirecc]].
     *
     * @return \yii\db\ActiveQuery|DireccionesQuery
     */
    public function getNDirecc()
    {
        return $this->hasOne(Direcciones::className(), ['id' => 'n_direcc']);
    }

    /**
     * {@inheritdoc}
     * @return ComCotizacionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotizacionQuery(get_called_class());
    }
    
    
    public function nitems(){
        return $this->getComDetcotis()->andWhere(['detcoti_id'=>$this->id])->count();
    }
    
    public function agregaCargos(){
      $cargos= ComCargos::find()->all();
      foreach($cargos as $cargo){
          ComCargoscoti::firstOrCreateStatic(
                  [
                      'coti_id'=>$this->id,
                      'cargo_id'=>$cargo->id,
                      'porcentaje'=>$cargo->porcentaje
                  ],null,
                  ['coti_id'=>$this->id,'cargo_id'=>$cargo->id]
                  );
         }
     
    
        
    }
    
    
    public function refreshMontos(){
        /*
         * Actualizar primero los montos de las partidas
         */
      $this->montoneto=$this->getPartidas()->select('sum(montoneto)')->scalar();
       yii::error('Sincronizando la cotizacion',__FUNCTION__);
      yii::error('monto neto '.$this->montoneto,__FUNCTION__);
      
            $this->montocargo=$this->montoneto*(1+$this->cargoPorcentajeAcumulado()/100);
     
      $this->igv=h::gsetting ('general', 'igv')*($this->montocargo+$this->montoneto);
      $this->monto=$this->getPartidas()->select('sum(total)')->scalar();
       yii::error('monto total sin igv  '.$this->monto,__FUNCTION__);
       $this->igv=h::gsetting ('general', 'igv')*($this->monto);
       yii::error(' igv  '.$this->igv,__FUNCTION__);
       $this->monto+=$this->igv;
       yii::error(' total toal  '.$this->monto,__FUNCTION__);
      return $this;
    }
    
   public function beforeSave($insert) {
      if($insert){
          $this->filtro='1';
          $this->version=0;
          $this->numero=$this->correlativo('numero');
          $this->codsoc= \common\models\masters\VwSociedades::codsoc();
          $this->estado=self::ESTADO_ABIERTO;
      }
       
      $this->refreshMontos();
      
       return parent::beforeSave($insert);
   } 
  public function afterSave($insert, $changedAttributes) {
       if(in_array('codmon',array_keys($changedAttributes)) && !$insert ){
           $this->changeBdPorTipoCambio($changedAttributes['codmon']);
        }
      return parent::afterSave($insert, $changedAttributes);
  } 
   
 private function generateNameForQr(){
     $arrayPieces=[
         $this->numero,
         $this->cliente1->rucpro,
         $this->monto,
         $this->codmon,
     ];
     return join('-',
            $arrayPieces);
 }
 
 public function fileQr(){
     
 }
 
 public function loadContactos(){
      $contactos= Contactos::find()->andWhere(['codpro'=>$this->codcli])->all();
      $contador=1;
      foreach($contactos as $contacto){
          ComContactocoti::firstOrCreateStatic(
                  [
                      'coti_id'=>$this->id,
                      'contacto_id'=>$contacto->id,
                      'codpro'=>$contacto->codpro,
                      'prioridad'=>$contador,
                      'send'=>'0',
                  ],null,
                  [
                      'coti_id'=>$this->id,
                      'contacto_id'=>$contacto->id,
                      'codpro'=>$contacto->codpro,                     
                  ]
                  );
          $contador++;
         }
 }
 
 /*Esta funcion devuelve los
  * nombres de lso modelos
  * involucrados en el log
  */
 private function modelsChild(){
     $basePath='';
     return [
         $basePath.'ComCotizacion',
         $basePath.'ComCargoscoti',
         $basePath.'ComContactoscoti',
         $basePath.'ComCotiDet',
         //$basePath.'ComCotidetalle'=>yii::t('base.names','Detalles'),
         $basePath.'ComCotigrupos',
         $basePath.'ComDetcoti',
     ];
 }
 
 /*Esta funcion  mapea los modelos y sus alias 
  * para el control de auditoria cosnolidado
  * 
  */
 public function mapModels(){
    
     $nombres= [
         yii::t('base.names','Encabezado'),
         yii::t('base.names','Cargos y comisiones'),
         yii::t('base.names','Contactos'),
         yii::t('base.names','Subpartidas'),
         yii::t('base.names','Partidas'),
         yii::t('base.names','Detalles'),
     ];
     return array_combine($this->modelsChild(),$nombres);
 }
 
 private function nameModel($alias){
     if(array_key_exists($alias, array_flip($this->mapModels())));
     return array_flip($this->mapModels())[$alias];
     return '';
 }
 
 /*
  * Dataprovider del log pero sin ordenar
  */
 
 private function queryLog(){
     $idspartidas=$this->getPartidas()->select('id')->column();//'ComCotigrupos',
     $idscargos=$this->getCargos()->select('id')->column();//'ComCargoscoti',
     $idsdetalles=$this->getComDetcotis()->select('id')->column(); //ComDetcoti    
    $idscontactos=$this->getContactos()->select('id')->column();//ComContactoscoti
    $idssubpartidas=$this->getSubpartidas()->select('id')->column();//ComContactoscoti
    
    $queryLog= Log::find()
     ->where([
       'and',
         ['clave'=>$this->id],
         ['like','model',$this->nameModel(yii::t('base.names','Encabezado'))],
         ])->orWhere
          (
          [ 'and',
                ['clave'=>$idscargos],
               ['like','model',$this->nameModel(yii::t('base.names','Cargos y comisiones'))],
          ]
            )->orWhere
          (
          [ 'and',
                ['clave'=>$idsdetalles],
               ['like','model',$this->nameModel(yii::t('base.names','Detalles'))],
          ]
            )->orWhere
          (
          [ 'and',
                ['clave'=>$idscontactos],
               ['like','model',$this->nameModel(yii::t('base.names','Contactos'))],
          ]
            )->orWhere
          (
          [ 'and',
                ['clave'=>$idssubpartidas],
               ['like','model',$this->nameModel(yii::t('base.names','Subpartidas'))],
          ]
            );
    return $queryLog;
 }
 
 
 public function providerLog(){
     
          
   return new \yii\data\ActiveDataProvider([
       'query'=>$this->queryLog()->orderBy(['model'=>SORT_ASC,'action'=>SORT_ASC,'creationdate'=>SORT_ASC]),
   ]);    
 }
 
   public function array_cargos(){
       /*$cache=h::cache();
       $keyCache=self::PREFIX_CACHE_CARGOS.$this->id;
       if(!$cache->get($keyCache)){
           yii::error('no hay cache',__FUNCTION__);
            yii::error($cache->get($keyCache),__FUNCTION__);
            $arreglo=$this->getCargos()->alias('t')->
             innerJoin('{{%com_cargos}} b', 't.cargo_id=b.id')->
               select(['b.etiqueta','t.porcentaje'])->orderBy(['b.id'=>SORT_ASC])->asArray()->all();
            $arreglo= array_combine(array_column($arreglo,'etiqueta'),array_column($arreglo,'porcentaje'));
            yii::error('El arreglo',__FUNCTION__);
             yii::error($arreglo,__FUNCTION__);
            $cache->set($keyCache,$arreglo);
            
       }else{
          $arreglo=$cache->get($keyCache);
           yii::error('El sacando del cache',__FUNCTION__);
             yii::error($arreglo,__FUNCTION__);
            $cache->set($keyCache,$arreglo);
          
       }*/
        $arreglo=$this->getCargos()->alias('t')->
             innerJoin('{{%com_cargos}} b', 't.cargo_id=b.id')->
               select(['b.etiqueta','t.porcentaje'])->orderBy(['b.id'=>SORT_ASC])->asArray()->all();
            $arreglo= array_combine(array_column($arreglo,'etiqueta'),array_column($arreglo,'porcentaje'));
           
     return $arreglo;
   } 
 
   public function changeBdPorTipoCambio($codmon){
       if($this->codmon===$codmon){
           
       }else{
          $cambio=h::tipoCambio($codmon)['compra'];
            self::updateAll([
                            'monto'=>$this->monto*$cambio,'igv'=>$this->igv*$cambio,'montoneto'=>$this->montoneto*$cambio,
                            ],
                    ['id'=>$this->id]); 
            $chain='punit*'.($cambio);
            ComDetcoti::updateAll([
                            'punit'=>new \yii\db\Expression('punit*'.$cambio),
                             'ptotal'=>new \yii\db\Expression('ptotal*'.$cambio),
                            'punitcalculado'=>new \yii\db\Expression('punitcalculado*'.$cambio),
                            'pventa'=>new \yii\db\Expression('pventa*'.$cambio),
                            'igv'=>new \yii\db\Expression('igv*'.$cambio),
                            ],
                    ['coti_id'=>$this->id]); 
            ComCotigrupos::updateAll([
                            'montoneto'=>new \yii\db\Expression('montoneto*'.$cambio),
                             'total'=>new \yii\db\Expression('total*'.$cambio),                           
                            ],
                    ['coti_id'=>$this->id]); 
            ComCargoscoti::updateAll([
                            'monto'=>new \yii\db\Expression('monto*'.$cambio),
                                                        
                            ],
                    ['coti_id'=>$this->id]); 
       }
       
   } 
   
   public function cargoPorcentajeAcumulado(){
      return $this->getCargos()->sum('porcentaje');
   }
   
  public function deleteCache(){
      h::cache()->delete(self::PREFIX_CACHE_CARGOS);
  }
  
  
  private function fixCoti_id($array_filas,$model){
      $array_data=[];
      foreach($array_filas as $fila){
           $array_data[]=array_replace($fila,['coti_id'=>$model->id,'id'=>null]);
      }
     return $array_data;
  }
  
  private function fixCoti_det($model){
      $array_data=[];
      $array_detalles_padres=$model->getSubpartidas()->asArray()->all();
      $array_detalles_hijos=$this->getComDetcotis()->asArray()->all();     
      foreach($array_detalles_padres as $filaPadre){
          foreach($array_detalles_hijos as $filaHijo){
                        $array_data[]=array_replace($filaHijo,[
                            'coti_id'=>$model->id,
                             'cotigrupo_id'=>$filaPadre['cotigrupo_id'],
                            'id'=>null,
                            'detcoti_id'=>$filaPadre['id']
                                ]);
                }
          }           
     return $array_data;  
  }
  
  
  private function fixCoti_subpartidas($model){
      $array_data=[];
      $array_partidas=$model->getPartidas()->asArray()->all();
      
      $array_subpartidas=$this->getSubpartidas()->asArray()->all();     
      foreach($array_partidas as $partida){
          foreach($array_subpartidas as $subpartida){
                        $array_data[]=array_replace($subpartida,['coti_id'=>$model->id,'id'=>null,'cotigrupo_id'=>$partida['id']]);
                }
          }           
     return $array_data;  
  }
  
  public function cloneFake(){
     $model=New \frontend\modules\com\models\ComCotiFake();
     $model->setAttributes($this->attributes);
     if(!$model->save()) return -1;
    
     $model->refresh();
     
     if(count($this->partidas)>0){
            $array_partidas=$this->getPartidas()->asArray()->all();
            Yii::$app->db->createCommand()->batchInsert(
            ComCotigrupos::tableName(),array_keys($this->partidas[0]->attributes),
            $this->fixCoti_id( $array_partidas,$model))->execute();
     }
     if(count($this->contactos)>0){
       $array_contactos=$this->getContactos()->asArray()->all();
        Yii::$app->db->createCommand()->batchInsert(
                ComContactocoti::tableName(),array_keys($this->contactos[0]->attributes),
            $this->fixCoti_id( $array_contactos,$model))->execute();
     } 
      if(count($this->subpartidas)>0){
         // $array_padres=$this->getSubpartidas()->asArray()->all();
          Yii::$app->db->createCommand()->batchInsert(
                  ComCotiDet::tableName(),array_keys($this->subpartidas[0]->attributes),
            $this->fixCoti_subpartidas($model))->execute();
      } 
      
      if(count($this->comDetcotis)>0){
          $array_detalles=$this->getComDetcotis()->asArray()->all();
          Yii::$app->db->createCommand()->batchInsert(
                  ComCotiDet::tableName(),array_keys($this->comDetcotis[0]->attributes),
            $this->fixCoti_det($model))->execute();
      } 
     
    if(count($this->cargos)>0){
          $array_cargos=$this->getCargos()->asArray()->all();
          Yii::$app->db->createCommand()->batchInsert(
                  ComCargoscoti::tableName(),array_keys($this->cargos[0]->attributes),
            $this->fixCoti_id($array_cargos,$model))->execute();
      } 
     
   return $model->id;
  }
  
  public function createVersion(){
      if($this->hasModifies()){
            $model=New \frontend\modules\com\models\ComCotiversiones();
            $model->coti_id=$this->id;
            $model->lastlog_id=$this->lastLog()->id;
            $transaccion=$this->getDb()->beginTransaction();            
           if($model->save() && $this->cloneFake()>0){
              $model->refresh();
              $model->attachPdf(); 
              $transaccion->commit();
            return $model->numero;

           }else{
               $transaccion->rollBack();
               return ['error' => yii::t('base.messages','Hubo un error en la creación de la version')];
     
           }
      }else{
          return null;
      }
  }
  
  public static function  getPdf($config=[]){
           $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
  $mpdf= new \Mpdf\Mpdf();
            $mpdf = new \Mpdf\Mpdf([
                'fontDir' => array_merge($fontDirs,[
                Yii::getAlias('@fonts')
                    ]),
    'fontdata' => $fontData + [
        'cour' => [
            'R' => 'Courier.ttf',
            
        ],
       'helvetica' => [
            'R' => 'Helvetica.ttf',
            'I' => 'VerdanaBOLD.ttf',
        ],
        'verdana' => [
            'R' => 'Verdana.ttf',
            'B' => 'VerdanaBOLD.ttf',
        ],
        
    ],
    'default_font' => 'cour'
]);    
           $mpdf->simpleTables = false;
            $mpdf->packTableData = true;
            
             $mpdf->margin_header = 1;
        $mpdf->margin_footer = 1;
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->setFooter('Página {PAGENO} de {nb}');
       
        
        //$mpdf->use_kwt = true; 
        //$mpdf->autoPageBreak = true;
      
         return $mpdf;
    }
  
  
   public function nItemsForReport(){
       $cuantospadre=$this->getComDetcotis()->count();
       //Ids de padres que deben mostrar
       $idsPadresMostrar=getComDetcotis()->select(['id'])->disctint()->andWhere(['mostrar'=>'1'])->column(); 
       $quitar=count($idsPadresMostrar);
       
      /*
       * Aquellos que son items hijos, ademas pertenecen 
       * a un padre que tiene mostrar='1'
       */
       $cuantoshijos=$this->getComDetcotis()
               ->andWhere(['in','detcoti_id',$idsPadresMostrar])->
               count(); 
       
       
      return $cuantospadre+$cuantoshijos-$quitar;
      
   }
   
   /*
    * Array preparado para mostrar el reporte 
    *   -PARTIDA1=>[
    *                01=>iTEM1
    *                02=>iTEM2
    *                   ],
    *   -PARTIDA2=>[
    *                01=>iTEM1
    *                02=>iTEM2
    *                   ],
    */
   
   public function itemsArrayToReport(){
       $items=[];
       $array_items=$this->getPartidas()->select(['x.descripcion as descridetalla'])->
               alias('a')
               ->innerJoin('{{%com_detcoti}} x','a.id=x.cotigrupo_id')->createCommand()->rawSql;
       
   }
/*
 * Evita el log de auditoria, usarlo en actualizaciones 
 * automaticas
 */
  public function retiraComportamientoLog(){
      $this->detachBehavior('auditoriaBehavior');
      return $this;
  }  
   
  public function Ums(){
     $query=new \yii\db\Query();
     return $query->select(['codum'])->from(ComDetcoti::tableName())->distinct()->
      andWhere(['coti_id'=>$this->id])->column();
  }
  
  /*
   * Retorna un carbon con la fecha ultima de la version
   * 
   */
  private function whenLastEnvio(){
      $registro=$this->getEnvios()->orderBy(['cuando'=>SORT_DESC])->one();
      if(is_null($registro)){
          return self::CarbonNow()->subDays(365*10);
      }else{
          return $registro->toCarbon('cuando');
      }
      
  }
  
  
  public function isTimeToSend(){
      return $this->CarbonNow()->gt($this->whenLastEnvio()->addSeconds(30));
  }
  
  public function lastEnvio(){
      return $this->getEnvios()->orderBy(['cuando'=>SORT_DESC])->one();
      
  }
  
  public function lastLog(){
      return $this->queryLog()->orderBy(['id'=>SORT_DESC])->one();
      
  }
  
  public function lastVersion(){
      return $this->getVersiones()->orderBy(['id'=>SORT_DESC])->one();
      
  }
  
  /*
   * Se fija si hubieron modificaciones 
   * en le registor del log
   * Si la el idlog de la ultima version 
   * es menor que el log actual entonces si hubo
   * modificaciones
   * 
   */
  public function hasModifies(){
      $lv=$this->lastVersion();
      $ll=$this->lastLog();
      if(!is_null($lv) && !is_null($ll)){
          return $lv->lastlog_id < $ll->id;
      }elseif(is_null($lv) && !is_null($ll)){ //Si no hay versiones pero si modificaciones
          return true;
      } elseif(!is_null($lv) && is_null($ll)){//Si hay versiones pero no modificaciones
          return false;
      } else{//Si no hay ambas
          return false;
      }    
  }
  
  public function hasSends(){
      return $this->getEnvios()->count()>0;
  }
  public function isAprobed(){
        return $this->estado==self::ESTADO_APROBADO;
    }
    
    
   /*
    * Verifica inconsistencias en la cotizacion 
    * por ejemplo partidas que no tienen subpartidas 
    */ 
  public function hasPartidasVacias(){
      //Verificando si la partida tiene regitros huérfanos 
      $idsDetalle=$this->getSubpartidas()->select(['cotigrupo_id'])->column();
      return $this->getPartidas()->andWhere([
          'not in',
          'id',
          $idsDetalle])->count()>0;
      
  }
  
}

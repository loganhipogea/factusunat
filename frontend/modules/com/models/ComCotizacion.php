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
    public $femision1=null;
    public $monto1=null;
    public $dateorTimeFields=[
     'femision'=>self::_FDATE,
      'femision1'=>self::_FDATE,   
         ];
    
    public $prefijo='78';
    
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
             [['monto','igv','version','filtro'], 'safe'],
            [['detalle_interno', 'detalle_externo'], 'string'],
            [['validez', 'n_direcc'], 'integer'],
            [['numero', 'codcli', 'codcli1', 'femision'], 'string', 'max' => 10],
            [['serie', 'codmon'], 'string', 'max' => 3],
            [['codsoc'], 'string', 'max' => 1],
            [['codcen'], 'string', 'max' => 5],
            [['estado'], 'string', 'max' => 2],
            [['descripcion'], 'string', 'max' => 40],
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
            'codcli' => Yii::t('app', 'Codcli'),
            'codcli1' => Yii::t('app', 'Codcli1'),
            'estado' => Yii::t('app', 'Estado'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle_interno' => Yii::t('app', 'Detalle Interno'),
            'detalle_externo' => Yii::t('app', 'Detalle Externo'),
            'femision' => Yii::t('app', 'Femision'),
            'validez' => Yii::t('app', 'Validez'),
            'codtra' => Yii::t('app', 'Codtra'),
            'n_direcc' => Yii::t('app', 'N Direcc'),
            'codmon' => Yii::t('app', 'Codmon'),
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
 
 public function providerLog(){
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
            )->orderBy(['model'=>SORT_ASC,'action'=>SORT_ASC,'creationdate'=>SORT_ASC]);
          
   return new \yii\data\ActiveDataProvider([
       'query'=>$queryLog,
   ]);    
 }
 
   public function array_cargos(){
       $cache=h::cache();
       if(!$cache->get(self::PREFIX_CACHE_CARGOS)){
            $arreglo=$this->getCargos()->alias('t')->
             innerJoin('{{%com_cargos}} b', 't.cargo_id=b.id')->
               select(['b.etiqueta','t.porcentaje'])->orderBy(['b.id'=>SORT_ASC])->asArray()->all();
            $arreglo= array_combine(array_column($arreglo,'etiqueta'),array_column($arreglo,'porcentaje'));
            $cache->set(self::PREFIX_CACHE_CARGOS,$arreglo);
            
       }else{
          $arreglo=$cache->get(self::PREFIX_CACHE_CARGOS);
       }
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
  
  
  private function fixCoti_id($array_filas,$id){
      $array_data=[];
      foreach($array_filas as $fila){
           $array_data[]=array_replace($fila,['coti_id'=>$id,'id'=>null]);
      }
     return $array_data;
  }
  
  
  public function cloneFake(){
     $model=New \frontend\modules\com\models\ComCotiFake();
     $model->setAttributes($this->attributes);
     $model->save();
     $model->refresh();
     
     if(count($this->partidas)>0){
            $array_partidas=$this->getPartidas()->asArray()->all();
            Yii::$app->db->createCommand()->batchInsert(
            ComCotigrupos::tableName(),array_keys($this->partidas[0]->attributes),
            $this->fixCoti_id( $array_partidas,$model->id))->execute();
     }
     if(count($this->contactos)>0){
       $array_contactos=$this->getContactos()->asArray()->all();
        Yii::$app->db->createCommand()->batchInsert(
                ComContactocoti::tableName(),array_keys($this->contactos[0]->attributes),
            $this->fixCoti_id( $array_contactos,$model->id))->execute();
     } 
      if(count($this->subpartidas)>0){
          $array_padres=$this->getSubpartidas()->asArray()->all();
          Yii::$app->db->createCommand()->batchInsert(
                  ComCotiDet::tableName(),array_keys($this->subpartidas[0]->attributes),
            $this->fixCoti_id($array_padres,$model->id))->execute();
      } 
      
      if(count($this->comDetcotis)>0){
          $array_detalles=$this->getComDetcotis()->asArray()->all();
          Yii::$app->db->createCommand()->batchInsert(
                  ComCotiDet::tableName(),array_keys($this->comDetcotis[0]->attributes),
            $this->fixCoti_id($array_detalles,$model->id))->execute();
      } 
     
    if(count($this->cargos)>0){
          $array_cargos=$this->getCargos()->asArray()->all();
          Yii::$app->db->createCommand()->batchInsert(
                  ComCargoscoti::tableName(),array_keys($this->cargos[0]->attributes),
            $this->fixCoti_id($array_cargos,$model->id))->execute();
      } 
     
   return $model->id;
  }
  
  public function createVersion(){
      $model=New \frontend\modules\com\models\ComCotiversiones();
      $model->coti_id=$this->id;
     yii::error($model->save(),__FUNCTION__);
      yii::error($model->getErrors(),__FUNCTION__);
      $this->cloneFake();
      $model->refresh();
      $model->attachPdf();
      return $model->numero;
  }
  
  public static function  getPdf($config=[]){
             $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
     
            $configInicial=['format'=>'A4',
                    'fontDir' => array_merge($fontDirs,[
                    Yii::getAlias('@fonts')
                    ]),
                        'fontdata' => $fontData + [
                            'cour' => [
                            'R' => 'cour.ttf',
                            'I' => 'CourierITALIC.ttf',
                        ]
                    ],];
            foreach($config as $key=>$value){
                    if(array_key_exists($key, $configInicial)){
                         $configInicial[$key]=$value;
                    }else{
                        $configInicial[$key]=$config[$key];  
                        }
                    }
 
            $mpdf = new \Mpdf\Mpdf($configInicial);
           $mpdf->simpleTables = true;
           $mpdf->packTableData = true;
           $mpdf->showImageErrors = true;
           $mpdf->curlAllowUnsafeSslRequests = true; //Permite imagenes de url externas
         return $mpdf;
    }
  
  
     

  
}

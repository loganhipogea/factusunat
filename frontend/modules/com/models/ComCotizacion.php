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
 * This is the model class for table "com_cotizaciones".
 *
 * @property int $id
 * @property string|null $numero
 * @property string|null $serie
 * @property string|null $codsoc
 * @property string|null $codcen
 * @property string|null $codcli
 * @property string|null $codcli1
 * @property string|null $estado
 * @property string|null $descripcion
 * @property string|null $detalle_interno
 * @property string|null $detalle_externo
 * @property string|null $femision
 * @property int|null $validez
 * @property string|null $codtra
 * @property int|null $n_direcc
 * @property string|null $codmon
 *
 * @property Centros $codcen0
 * @property Clipro $codcli0
 * @property Clipro $codcli10
 * @property Trabajadores $codtra0
 * @property ComDetcoti[] $comDetcotis
 * @property Direcciones $nDirecc
 */
class ComCotizacion extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
    public $femision1=null;
    public $monto1=null;
    public $dateorTimeFields=[
     'femision'=>self::_FDATE,
      'femision1'=>self::_FDATE,   
         ];
    
    public $prefijo='78';
    
    public static function tableName()
    {
        return 'com_cotizaciones';
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
             [['monto','igv'], 'safe'],
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
    public function getCodtra0()
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
        return $this->hasMany(ComCotidet::className(), ['coti_id' => 'id']);
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
    
    
    public function refreshMonto(){
        /*
         * Actualizar primero los montos de las partidas
         */
      $this->montoneto=$this->getPartidas()->select('sum(total)')->scalar();
      $this->montoneto=($this->montoneto>0)?$this->montoneto:0;
      
      /*
       * Ahora veamos que este monto debe de 
       */
      $this->montocargo=$this->getCargos()->select('sum(porcentaje)')->scalar();
      $this->montocargo=($this->montocargo>0)?$this->montocargo:0;
      $this->montocargo=$this->montoneto*$this->montocargo/100;
      /***************************************/
      
      $this->monto=$this->montoneto+$this->montocargo;
      $this->igv=h::gsetting ('general', 'igv')*$this->monto;
      $this->monto+=$this->igv;
      return $this->save();
    }
    
   public function beforeSave($insert) {
      
       $this->numero=$this->correlativo('numero');
       return parent::beforeSave($insert);
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
     $basePath='frontend/modules/com/models/';
     return [
         $basePath.'ComCotizacion',
         $basePath.'ComCargoscoti',
         $basePath.'ComContactoscoti',
         $basePath.'ComCotidet',
         //$basePath.'ComCotidetalle'=>yii::t('base.names','Detalles'),
         $basePath.'ComCotigrupos',
         $basePath.'ComDetcoti',
     ];
 }
 
 /*Esta funcion  mapea los modelos y sus alias 
  * para el control de auditoria cosnolidado
  * 
  */
 private function mapModels(){
    
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
 
 public function idsLog(){
     $idspartidas=$this->getPartidas()->select('id')->column();//'ComCotigrupos',
     $idscargos=$this->getCargos()->select('id')->column();//'ComCargoscoti',
     $idsdetalles=$this->getComDetcotis()->select('id')->column(); //ComDetcoti    
    $idscontactos=$this->getContactos()->select('id')->column();//ComContactoscoti
    $idssubpartidas=$this->getSubpartidas()->select('id')->column();//ComContactoscoti
    
     Log::find()->where([
        'model'=> array_flip($this->mapModels())[ yii::t('base.names','Encabezado')],
        'id'=>$idspartidas,
    ])->orWhere([
        'model'=> array_flip($this->mapModels())[ yii::t('base.names','Cargos y comisiones')],
        'id'=>$idscargos,
        
    ])->orWhere([
        'model'=> array_flip($this->mapModels())[ yii::t('base.names','Contactos')],
       ])->orWhere([
         'id'=>$idscontactos,
        
    ])->orWhere([
        'model'=> array_flip($this->mapModels())[ yii::t('base.names','Subpartidas')],
       ])->orWhere([
         'id'=>$idssubpartidas,
        
    ])->orWhere([
        'model'=> array_flip($this->mapModels())[ yii::t('base.names','Detalles')],
       ])->orWhere([
         'id'=>$idsdetalles,
        
    ]);
    
 }
    
}

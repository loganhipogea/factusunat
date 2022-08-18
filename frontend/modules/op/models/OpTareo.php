<?php

namespace frontend\modules\op\models;
use common\models\masters\Direcciones;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%op_tareo}}". 
 * @property OpTareodet[] $opTareodets
 */
class OpTareo extends \common\models\base\modelBase
{
  use \common\traits\timeTrait; 
    
  
   public $fecha1=null;
   public $semana1;
    public $booleanFields=['esferiado'];
     public $dateorTimeFields=[
        'fecha'=>self::_FDATE,
        'fecha1'=>self::_FDATE,
       // 'hfin'=>self::_FHOUR
       ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_tareo}}';
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
        return [
            [['direcc_id', /*'proc_id', 'os_id', 'detos_id'*/], 'required'],
            [['direcc_id', 'proc_id', 'os_id', 'detos_id'], 'integer'],
            [['detalle'], 'string'],
            [['esferiado','semana','os_id','detos_id'], 'safe'],
            [['fecha'], 'string', 'max' => 10],
            [['hinicio', 'hfin'], 'string', 'max' => 5],
            [['descripcion'], 'string', 'max' => 40],
            [['detos_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpOsdet::className(), 'targetAttribute' => ['detos_id' => 'id']],
            [['direcc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direcciones::className(), 'targetAttribute' => ['direcc_id' => 'id']],
            [['proc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpProcesos::className(), 'targetAttribute' => ['proc_id' => 'id']],
            [['os_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpOs::className(), 'targetAttribute' => ['os_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'hinicio' => Yii::t('app', 'Hinicio'),
            'hfin' => Yii::t('app', 'Hfin'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'direcc_id' => Yii::t('app', 'Direcc ID'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'os_id' => Yii::t('app', 'Os ID'),
            'detos_id' => Yii::t('app', 'Detos ID'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpLibros()
    {
        return $this->hasMany(OpLibro::className(), ['tareo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetos()
    {
        return $this->hasOne(OpOsdet::className(), ['id' => 'detos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirecc()
    {
        return $this->hasOne(Direcciones::className(), ['id' => 'direcc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProc()
    {
        return $this->hasOne(OpProcesos::className(), ['id' => 'proc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOs()
    {
        return $this->hasOne(OpOs::className(), ['id' => 'os_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalles()
    {
        return $this->hasMany(OpTareodet::className(), ['tareo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OpTareoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpTareoQuery(get_called_class());
    }
    
    
    
    public function creaHijo(){
        $model=OpLibro::instance(); 
        $model->setAttributes([
            'tareo_id'=>$this->id,
            'hinicio'=>$this->hinicio,
            'proc_id'=>$this->proc_id,
            'os_id'=>$this->os_id,
            'detos_id'=>$this->detos_id,
            'descripcion'=>'Inicio de actividades',
            
        ]);
        //print_r($model->attributes); die();
            return $model->save();
    }
    
    public function createWorker($modeloTrabajador){
        $model= new OpTareodet(); 
        $model->setAttributes([
            'tareo_id'=>$this->id,
            'hinicio'=>$this->hinicio,
            'hfin'=>$this->hfin,
            'proc_id'=>$this->proc_id,
            'codtra'=>$modeloTrabajador->codtra,
            'semana'=>$modeloTrabajador->semana,
            'os_id'=>$modeloTrabajador->os_id,
            'detos_id'=>$modeloTrabajador->detos_id,
           
        ]);
        //print_r($model->attributes); die();
            yii::error($model->save(),__FUNCTION__);
             yii::error($model->getErrors(),__FUNCTION__);
           
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->semana=date('W');
            $this->esferiado= $this->isHolyDay($this->toCarbon('fecha'));
        }
        return parent::beforeSave($insert);
    }
    
    
    public function afterSave($insert, $changedAttributes) {
        $this->refresh();
       // print_r($this->attributes); die();
        if($insert)
        //$this->creaHijo();
        return parent::afterSave($insert, $changedAttributes);
    }
    
    
     public function preparePdfReport(){   
       $socio=\common\models\masters\VwSociedades::currentCompanyModel();
       $formato=h::formato();
       $numero= uniqid();
      // h::money()->setCurrentMoneyInCache($this->codmon);
       $targetPath=yii::getAlias('@temp').'/'. $numero.'.pdf';
       $fileQr=yii::getAlias('@temp').'/'. $numero.'QR.png';       
       $pdf=New \FPDF('P','mm',array(201,297)); 
        $qrCode = (new \Da\QrCode\QrCode($this->generateNameForQr()))
            ->setSize(100)
            ->setMargin(1);   
                $qrCode->writeFile($fileQr);      
        $pdf->AddPage();
                //define('EURO',$this->codmon);
       // CABECERA
            $pdf->SetFont('Courier','B',10);
            /*
             *    NOMBRE DE LA EMPRESA
             */
            $pdf->Cell(210,6,$socio->despro,0,1,'L');
            
          //TITULO DEL DOCUMENTO 
            $pdf->SetFont('Courier','B',14);
            $pdf->Cell(200,5,'PARTE TAREO DIARIO',0,1,'C');
             $pdf->Ln(4);
            
           //CLIENTE
            $pdf->SetFont('Courier','',10);
            $pdf->Cell(40,5,'Cliente :',0,1,'L');  
            $pdf->Cell(150,5,'',0,1,'L');  
             $pdf->Ln(1);
             
            //NOMBRE PROYECTO
            $pdf->Cell(30,5,'Proyecto :',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(170,5,$this->proc->descripcion,0,0,'L');
            $pdf->SetFont('Courier','',10);
            $pdf->Ln(5);
            
           //fecha
            $pdf->Cell(30,5,'Fecha :',0,0,'L'); 
             $pdf->SetFont('Courier','B',10);
            $pdf->Cell(170,5,$this->fecha,0,'L');
            $pdf->SetFont('Courier','',10);
             $pdf->Ln(5);
             
             //LOCACION
            $pdf->Cell(30,5,'LOCACION :',0,0,'L');
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(170,5,$this->direcc->direc,0,0,'L');  
            $pdf->SetFont('Courier','',10);
            $pdf->Ln(5);
            
            //NUMERO SEMANA
            $pdf->Cell(30,5,'SEMANA :',0,0,'L');
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(170,5,$this->semana,0,0,'L');  
            $pdf->SetFont('Courier','',10);
            $pdf->Ln(5);
            
            
            //DETALLES
            $pdf->Cell(40,8,'Info :','B',0,'L');  
            $pdf->Cell(140,8,$this->detalle,'B',0,'L');  
            $pdf->Ln(10); 
            
             // CABECERA
             $pdf->SetFont('Courier','B',10);
               $pdf->Cell(15,5,'Cod','B',0,'L');
                $pdf->Cell(90, 5,'Nombres y apellidos','B',0,'L');
                $pdf->Cell(15, 5,'Hi','B',0,'L');
                $pdf->Cell(15, 5,'Hs','B',0,'L');
                 $pdf->Cell(15, 5,'H.Trab','B',0,'L'); 
                 $pdf->Cell(15, 5,'H.Ex','B',0,'L'); 
                  $pdf->Cell(15, 5,'','B',0,'L'); 
                  $pdf->Ln(10); 
              $pdf->SetFont('Courier','',10);
        // TRABAJADORES
           
            foreach($this->detalles as $detail){           
                //$pdf->MultiCell(30,5,$detail->descripcion,0,'L'); 
                $pdf->Cell(15,5, $detail->codtra,0,0,'L');
                $pdf->Cell(90, 5, $detail->trabajador->fullName(),0,0,'L');
                $pdf->Cell(15, 5, $detail->hinicio,0,0,'L');
                $pdf->Cell(15, 5, $detail->hfin,0,0,'L');
                 $pdf->Cell(15, 5, $detail->htotales,0,0,'L'); 
                 $pdf->Cell(15, 5, $detail->hextras,0,0,'L'); 
                $pdf->Ln(5); 
            }
    
        $pdf->Image($fileQr);    
        $pdf->Output($targetPath,'f');
        $this->attachFromPath($targetPath);
        //@unlink($targetPath);
   }
   
   private function generateNameForQr(){
       return $this->fecha.'||'.$this->proc->cliente->despro.'||'.
       $this->proc->numero.'||'.  $this->proc->descripcion;   
   }
   
   public function next(){
       $id=$this->find()->select(['min(id)'])->
       andWhere(['>','id',$this->id])->
               scalar();
      if($id>0)return self::findOne ($id);
      return null;
       
   }
   
   public function previous(){
      $id=$this->find()->select(['max(id)'])->
       andWhere(['<','id',$this->id])->
               scalar();
      if($id>0)return self::findOne ($id);
      return null; 
   }
   
   public function clonePeople(){
    
       if(!is_null($model=$this->previous())){
           
       }else{
          return false; 
       }
         
   
       
     
       foreach($model->detalles as $trabajador){
           $this->createWorker($trabajador);
       }
       return true;
   }
   
   public function nWorkers(){
       return $this->getDetalles()->count();
   }
   
}

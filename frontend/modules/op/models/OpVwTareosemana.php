<?php

namespace frontend\modules\op\models;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%op_vw_tareosemana}}".
 *
 * @property int $proc_id
 * @property string|null $codtra
 * @property int|null $semana
 * @property string $ap
 * @property string $nombres
 * @property string $codpuesto
 * @property string $numero
 * @property string|null $descripcion
 * @property float|null $costo
 * @property float|null $htotales
 * @property float|null $hextras
 * @property float|null $basico
 * @property float|null $dominical
 * @property float|null $adicional
 */
class OpVwTareosemana extends \common\models\base\modelBase
{
    
    public $semana1;
    public $costo1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_vw_tareosemana}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proc_id', 'ap', 'nombres', 'codpuesto', 'numero'], 'required'],
            [['proc_id', 'semana'], 'integer'],
            [['costo', 'htotales', 'hextras', 'basico', 'dominical', 'adicional'], 'number'],
            [['codtra', 'numero'], 'string', 'max' => 6],
            [['ap', 'nombres', 'descripcion'], 'string', 'max' => 40],
            [['codpuesto'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'proc_id' => Yii::t('base.names', 'Proc ID'),
            'codtra' => Yii::t('base.names', 'Cod'),
            'semana' => Yii::t('base.names', 'Semana'),
            'ap' => Yii::t('base.names', 'Ap'),
            'nombres' => Yii::t('base.names', 'Nombres'),
            'codpuesto' => Yii::t('base.names', 'Puesto'),
            'numero' => Yii::t('base.names', 'Número'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'costo' => Yii::t('base.names', 'Total'),
            'htotales' => Yii::t('base.names', 'Hr total'),
            'hextras' => Yii::t('base.names', 'Hr extr'),
            'basico' => Yii::t('base.names', 'Básico'),
            'dominical' => Yii::t('base.names', 'Dominical'),
            'adicional' => Yii::t('base.names', 'Extras'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return OpVwTareosemanaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpVwTareosemanaQuery(get_called_class());
    }
    
   
    
    private function previousYear(){
       return $this->find()->select(['max(anio)'])
                ->andWhere(['<','anio',$this->anio])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                ])
               ->scalar();       
    }
    
     private function nextYear(){
       return $this->find()->select(['min(anio)'])
                ->andWhere(['>','anio',$this->anio])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                ])
               ->scalar();       
    }
    
    private function firstYear(){
       return $this->find()->select(['min(anio)'])
                //->andWhere(['<>','anio',$this->anio])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                ])
               ->scalar();       
    }
    
    private function maxYear(){
       return $this->find()->select(['max(anio)'])
                //->andWhere(['<>','anio',$this->anio])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                ])
               ->scalar();       
    }
    
     private function maxWeekYear($anio){
       return $this->find()->select([
                        'max(semana)'
                    ])
               ->andWhere([
                   'anio'=>$anio,
                   //'semana'=>$this->firstWeek()
                   ])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                    
                ])
               ->scalar(); 
    }
    
     private function minWeekYear($anio){
       return $this->find()->select([
                        'min(semana)'
                    ])
               ->andWhere([
                   'anio'=>$anio,
                   //'semana'=>$this->firstWeek()
                   ])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                    
                ])
               ->scalar(); 
    }
    
   
    
    
    public function firstRecord(){       
          return $this->find()
               ->andWhere([
                   'anio'=>$this->firstYear(),
                   'semana'=>$this->minWeekYear($this->firstYear())])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                    
                ])
               ->one();
       }
   public function lastRecord(){       
          return $this->find()
               ->andWhere([
                   'anio'=>$this->maxYear(),
                   'semana'=>$this->maxWeekYear($this->maxYear())])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                    
                ])
               ->one();
       }
          
   public function previousRecord(){
       if($year=$this->previousYear()>0
               && $this->semana==1
               ){//Si tiene previo año 
               return  $this->find()->andWhere([
                   'anio'=>$year,
                   'semana'=>$this->maxWeekYear($year)
                   ])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                    
                ])
               ->one(); 
               } 
               return  $this->find()->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                    'anio'=>$this->anio,
                        ])->andWhere(
                                [
                                    '<','semana',$this->semana
                                ])
                    ->orderBy(['semana'=>SORT_DESC])
                    ->one();   
   }
   public function nextRecord(){
       if($year=$this->nextYear()>0
               && $this->semana==52
               ){//Si tiene previo año 
               return  $this->find()->andWhere([
                   'anio'=>$year,
                   'semana'=>$this->minWeekYear($year)
                   ])
                ->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                    
                ])
               ->one(); 
               } 
               return  $this->find()->andWhere([
                    'proc_id'=>$this->proc_id,
                    'codtra'=>$this->codtra,
                    'anio'=>$this->anio,
                        ])->andWhere(
                                [
                                    '>','semana',$this->semana
                                ])
                    ->orderBy(['semana'=>SORT_ASC])
                    ->one();   
   }
   
  private function generateNameForQr(){
       return $this->codtra.'||'.$this->ap.'||'.
       $this->nombres.'||'.  $this->semana;   
   } 
   
  public function preparePdfReport(){   
       $socio=\common\models\masters\VwSociedades::currentCompanyModel();
      
       $formato=h::formato();
       $numero= uniqid();
      // h::money()->setCurrentMoneyInCache($this->codmon);
       
      $dias= OpTareodet::find()
         ->andWhere(['codtra'=>$this->codtra,'proc_id'=>$this->proc_id])
         ->orderBy(['id'=>SORT_ASC])->all();
               
               
               
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
             $pdf->Ln(20);
          //TITULO DEL DOCUMENTO 
            $pdf->SetFont('Courier','B',14);
            $pdf->Cell(200,5,'RESUMEN SEMANAL '.$this->nombres.' '.$this->ap,0,1,'C');
            
            $pdf->Ln(5);
            //NUMERO SEMANA
            
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(200,5,'SEMANA  :'.$this->semana.'-'.$this->anio,0,0,'C');  
            $pdf->SetFont('Courier','',10);
            $pdf->Ln(5);
            $pdf->Ln(5);
            
           //CLIENTE
            $pdf->SetFont('Courier','',10);
            $pdf->Cell(40,5,'Cliente :',0,1,'L');  
            $pdf->Cell(150,5,'',0,1,'L');  
             $pdf->Ln(1);
             
            //NOMBRE PROYECTO
            $pdf->Cell(30,5,'Proyecto :',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(170,5,$this->descripcion,0,0,'L');
            $pdf->Ln(5);
            $pdf->SetFont('Courier','',10);
            $pdf->Cell(30,5,'Regimen :',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(170,5,$this->codigo,0,0,'L');
            $pdf->SetFont('Courier','',10);
            $pdf->Ln(5);
            
            $pdf->SetFont('Courier','',10);
            $pdf->Cell(30,5,'Cargo :',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(170,5, \common\models\masters\Trabajadores::comboValueTextStatic('codpuesto',$this->codpuesto),0,0,'L');
            $pdf->SetFont('Courier','',10);
            $pdf->Ln(5);
            
            $pdf->SetFont('Courier','',10);
            $pdf->Cell(30,5,'Costo hora :',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(170,5, $this->costohora,0,0,'L');
            $pdf->SetFont('Courier','',10);
            
            $pdf->Ln(15);
         
             
            
            
            
             // CABECERA
             $pdf->SetFont('Courier','B',10);
                 $pdf->Cell(25, 5,'Día','BTL',0,'L');
                $pdf->Cell(25, 5,'Fecha','BT',0,'L');                 
                $pdf->Cell(15, 5,'Hi','BT',0,'R');
                $pdf->Cell(15, 5,'Hs','BT',0,'R');
                 $pdf->Cell(15, 5,'H.Trab','BT',0,'R'); 
                 $pdf->Cell(15, 5,'H.Ex','BT',0,'C'); 
                 $pdf->Cell(15, 5,'Base','LBT',0,'C');
                 $pdf->Cell(15, 5,'Domin','BT',0,'R');
                 $pdf->Cell(20, 5,'Extra','BT',0,'R');
                  $pdf->Cell(25, 5,'Total','BTR',0,'R'); 
                  $pdf->Ln(5); 
              $pdf->SetFont('Courier','',10);
        // TRABAJADORES
           
            foreach($dias as $dia){           
                //$pdf->MultiCell(30,5,$detail->descripcion,0,'L');
                $pdf->Cell(25,5,\common\helpers\timeHelper::daysOfWeek()[$dia->tareo->toCarbon('fecha')->weekDay()],'L',0,'L');
                $pdf->Cell(25,5, $dia->tareo->fecha,0,0,'L');
                 $pdf->Cell(15, 5, $dia->hfin,0,0,'R');
                 $pdf->Cell(15, 5, $dia->hfin,0,0,'R');
                $pdf->Cell(15, 5, $dia->htotales,0,0,'R');
                $pdf->Cell(15, 5, $dia->hextras,0,0,'C');
                 $pdf->Cell(15, 5, $dia->basico,'L',0,'C'); 
                 $pdf->Cell(15, 5, $dia->dominical,0,0,'R'); 
                  $pdf->Cell(20, 5, $dia->adicional,0,0,'R'); 
                  $pdf->Cell(25, 5, $dia->costo,'R',0,'R'); 
                $pdf->Ln(5); 
            }
     // footer
             $pdf->SetFont('Courier','B',10);
                 $pdf->Cell(25, 5,'','T',0,'L');
                $pdf->Cell(25, 5,'','T',0,'L');                 
                $pdf->Cell(15, 5,'','T',0,'R');
                $pdf->Cell(15, 5,'Totales:','TR',0,'R');
                 $pdf->Cell(15, 5,$this->htotales,'BT',0,'R'); 
                 $pdf->Cell(15, 5,$this->hextras,'BT',0,'C'); 
                 $pdf->Cell(15, 5,$this->basico,'LBT',0,'C');
                 $pdf->Cell(15, 5,$this->dominical,'BT',0,'R');
                 $pdf->Cell(20, 5,$this->adicional,'BT',0,'R');
                  $pdf->SetFont('Courier','B',11);
                  $pdf->Cell(25, 5,$this->costo,'BTR',0,'R'); 
                 $pdf->SetFont('Courier','B',10);
                  $pdf->Ln(15); 
              $pdf->SetFont('Courier','',10);
              
         //DETALLES DEL REGIMEN
            $pdf->Cell(60,5,'Factor dominical:',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(140,5,$this->porc_dominical,0,0,'L');
            $pdf->Ln(5);
            
             $pdf->SetFont('Courier','',10);
             $pdf->Cell(60,5,'Factor feriado:',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(140,5,$this->porc_feriado,0,0,'L');
            $pdf->SetFont('Courier','',10);
            $pdf->Ln(5);
            
            $pdf->SetFont('Courier','',10);
             $pdf->Cell(60,5,'Factor refrigerio:',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(140,5,$this->porc_refrigerio,0,0,'L');
            $pdf->Ln(5);
            
            $pdf->SetFont('Courier','',10);
             $pdf->Cell(60,5,'Factor nocturno:',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(140,5,$this->porc_nocturno,0,0,'L');
            $pdf->Ln(5);
            
            $pdf->SetFont('Courier','',10);
            $pdf->Cell(60,5,'Factor horas extras:',0,0,'L'); 
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell(140,5,$this->porc_hextras,0,0,'L');
            $pdf->SetFont('Courier','',10);
            $pdf->Ln(5);
            
            $pdf->Ln(15);
               
              
         $pdf->Ln(15);     
        $pdf->Image($fileQr);    
         return $pdf->Output();
        // return $targetPath;
        //$this->attachFromPath($targetPath);
        //@unlink($targetPath);
   }   
}

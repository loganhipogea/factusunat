<?php
declare(strict_types=1);
namespace frontend\modules\sunat\controllers;
use yii\web\Controller;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;
use frontend\modules\sunat\envio\src\Util;
use frontend\modules\sunat\models\SunatSends;
USE frontend\modules\sunat\models\SunatSendSumary;
USE frontend\modules\com\models\ComFactura;
use common\helpers\h;
/**
 * Default controller for the `sunat` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTest(){
        require __DIR__ . '/../envio/vendor/autoload.php'; 
       $util=Util::getInstance();
       $model=\frontend\modules\com\models\ComFactura::findOne(145);
      //$model->refreshValues();
      $invoice = $model->createInvoiceGreenter();
         
    /*$invoice
    ->setUblVersion('2.1')
    ->setFecVencimiento(new \DateTime())
    ->setTipoOperacion('0101')
    ->setTipoDoc('01')
    ->setSerie('F001')
    ->setCorrelativo('125')
    ->setFechaEmision(new \DateTime())
    ->setFormaPago(new FormaPagoContado())
    ->setTipoMoneda('PEN')
    ->setCompany($util->shared->getCompany())
    ->setClient($util->shared->getClient())
    ->setMtoOperGravadas(200)
    ->setMtoOperExoneradas(100)
    ->setMtoIGV(36)
    ->setTotalImpuestos(36)
    ->setValorVenta(300)
    ->setSubTotal(336)
    ->setMtoImpVenta(336)
    ;*/
  
        $items = [];

        /*->setCodProducto('P001')
    ->setUnidad('NIU')
    ->setDescripcion('PROD 1')
    ->setCantidad(2)
    ->setMtoValorUnitario(100)
    ->setMtoValorVenta(200)
    ->setMtoBaseIgv(200)
    ->setPorcentajeIgv(18)
    ->setIgv(36)
    ->setTipAfeIgv('10') // Catalog: 07
    ->setTotalImpuestos(36)
    ->setMtoPrecioUnitario(118)
;*/        
        foreach($model->details as $detail){            
            $items[]=(new SaleDetail())
                ->setCodProducto($detail->codart)
                ->setUnidad($detail->codum)
                ->setDescripcion($detail->material->descripcion)
                ->setCantidad($detail->cant+0)
                ->setMtoValorUnitario($detail->punit+0)
                ->setMtoValorVenta($detail->pventa+0)
                ->setMtoBaseIgv($detail->pventa+0)
                ->setPorcentajeIgv(18)
                ->setIgv($detail->igv+0)
                ->setTipAfeIgv('10') // Catalog: 07
                ->setTotalImpuestos($detail->igv+0) ///REVISAR ESTO
                ->setMtoPrecioUnitario(round($detail->punitgravado+0,2)) //REVISAR: DEBE DE AGFRGARSE TODOS TODOS LOS IMPUETROS Y RESTAR EL DESCUENTRO
                ;

            
        }
        
  

    $invoice->setDetails($items)
    ->setLegends([
        (new Legend())
            ->setCode('1000')
            ->setValue('SON TRESCIENTOS TREINTA Y SEIS CON OO/100 SOLES')
    ]);
    
    $see = $util->getSee(SunatEndpoints::FE_BETA);

/** Si solo desea enviar un XML ya generado utilice esta función**/
//$res = $see->sendXml(get_class($invoice), $invoice->getName(), file_get_contents($ruta_XML));

$res = $see->send($invoice);
$util->writeXml($invoice, $see->getFactory()->getLastXml());

if (!$res->isSuccess()) {
    echo $util->getErrorResponse($res->getError());

    exit();
}

/**@var $res BillResult*/
$cdr = $res->getCdrResponse();
$util->writeCdr($invoice, $res->getCdrZip());
$util->showResponse($invoice, $cdr);
    }
    
    
    public function actionAjaxSendInvoiceStd($id){
         require __DIR__ . '/../envio/vendor/autoload.php'; 
            $util=Util::getInstance();
            $model=\frontend\modules\com\models\ComFactura::findOne($id);
             $invoice = $model->createInvoiceGreenter();
             $items = [];
        foreach($model->details as $detail){            
            $items[]=(new SaleDetail())
                ->setCodProducto($detail->codart)
                ->setUnidad($detail->codum)
                ->setDescripcion($detail->material->descripcion)
                ->setCantidad($detail->cant+0)
                ->setMtoValorUnitario($detail->punit+0)
                ->setMtoValorVenta($detail->pventa+0)
                ->setMtoBaseIgv($detail->pventa+0)
                ->setPorcentajeIgv(18)
                ->setIgv($detail->igv+0)
                ->setTipAfeIgv('10') // Catalog: 07
                ->setTotalImpuestos($detail->igv+0) ///REVISAR ESTO
                ->setMtoPrecioUnitario(round($detail->punitgravado+0,2)) //REVISAR: DEBE DE AGFRGARSE TODOS TODOS LOS IMPUETROS Y RESTAR EL DESCUENTRO
                ;
                  }
            $invoice->setDetails($items)
                ->setLegends([
                        (new Legend())
                        ->setCode('1000')
                        ->setValue('SON TRESCIENTOS TREINTA Y SEIS CON OO/100 SOLES')
                ]);    
            $see = $util->getSee(SunatEndpoints::FE_BETA);
            $res = $see->send($invoice);
            $util->writeXml($invoice, $see->getFactory()->getLastXml());
               h::response()->format = \yii\web\Response::FORMAT_JSON;   
                    
         
                if (!$res->isSuccess()) {
                            $error=$res->getError();
                            $errores=[
                                'code'=>$error->getCode(),
                                'message'=>$error->getMessage()
                                ];
                            $transaccion=$model->getDb()->beginTransaction();
                            //;
                           
                            if($model->setRejectedSunat()->save() &&                           
                               $model->storeSend($errores,false)){
                                
                                $transaccion->commit();
                                \yii::error($model->setRejectedSunat()->save());
                                \yii::error($model->storeSend($errores,false));
                                \yii::error('Hizo commit');
                            }else{
                                \yii::error($model->setRejectedSunat()->save());
                                \yii::error($model->storeSend($errores,false));
                                \yii::error('Hizo rollback');
                                $transaccion->rollback();
                                //var_dump($model->setRejectedSunat()->save(),$model->storeSend($errores,false));
                            
                                return ['error' =>\yii::t('base.errors','There were some errors before send, please fix them, and try again')];   
                            }
                            //var_dump($res->getError());
                            return ['error' =>\yii::t('base.errors','There are some errors')];  
                        //echo $util->getErrorResponse($res->getError());
                    }else{
                         /**@var $res BillResult*/
                            $cdr = $res->getCdrResponse();
                            $util->writeCdr($invoice, $res->getCdrZip());
                            $cdrArray=[
                                'id'=>$cdr->getId(),
                                'code'=>$cdr->getCode(),
                                'description'=>$cdr->getDescription(),
                                'notes'=>$cdr->getNotes(),
                            ];
                            
                            /*
                             * ADJUNTA LOS ARCHIVOS AL MODELO
                             */
                                
                            
                            
                            $transaccion=$model->getDb()->beginTransaction();
                             //var_dump($model->setRejectedSunat()->save(),$model->storeSend($cdrArray,false));
                           
                             if($model->setPassedSunat()->save() &&                           
                               $model->storeSend($cdrArray,true)){
                                $transaccion->commit();
                            }else{
                                $transaccion->rollback();
                                
                                return ['error' =>\yii::t('base.errors','There were some errors before send, please fix them, and try again')];  
                            }
                            
                             return ['success' =>' -  '.\yii::t('base.errors','The document was send successfully')]; 
                    }

               
    }
    
  public function actionAjaxExpandSend(){
     
    if (isset($_POST['expandRowKey'])) {
        $model = SunatSends::findOne($_POST['expandRowKey']+0);
          
        if($model->resultado){
            //var_dump($model->mensaje);die();
            return $this->renderPartial('_send_result_success', ['model'=>$model,'cdr'=>$model->mensaje]);
        }else{ 
            //var_dump($model->mensaje);die();
            return $this->renderPartial('_send_result_error', ['error'=>$model->mensaje]);
        }
        
    } 

  }
  public function actionAjaxExpandSummarySend(){
      
            
    if (h::request()->isAjax) {
        $id = h::request()->post('expandRowKey');
        $model = SunatSendSumary::findOne($id);
        
        
        if($model->resultado){
            //var_dump($model->mensaje);die();
            return $this->renderPartial('_send_result_success', ['model'=>$model,'cdr'=>$model->mensaje]);
        }else{ 
            //var_dump($model->mensaje);die();
            return $this->renderPartial('_send_result_error', ['error'=>$model->mensaje]);
        }
        
    } 

  }
  
 public function actionAjaxSendVoucherStd($id){
         require __DIR__ . '/../envio/vendor/autoload.php'; 
            $util=Util::getInstance();
            $model=\frontend\modules\com\models\ComFactura::findOne($id);
             $invoice = $model->createVoucherGreenter();
             $items = [];
         

        foreach($model->details as $detail){            
            $items[]=(new SaleDetail())
                ->setCodProducto($detail->codart)
                ->setUnidad($detail->codum)
                ->setDescripcion($detail->material->descripcion)
                ->setCantidad($detail->cant+0)
               // ->setMtoValorUnitario($detail->punit+0)
                //->setMtoValorVenta($detail->pventa+0)
                ->setMtoBaseIgv($detail->pventa+0)
                ->setPorcentajeIgv(18)
                ->setIgv($detail->igv+0)
                ->setTipAfeIgv('10') // Catalog: 07
                ->setTotalImpuestos($detail->igv+0) ///REVISAR ESTO
                ->setMtoValorVenta($detail->pventa+0)
                 ->setMtoValorUnitario($detail->punit+0)    
                ->setMtoPrecioUnitario(round($detail->punitgravado+0,2)) //REVISAR: DEBE DE AGFRGARSE TODOS TODOS LOS IMPUETROS Y RESTAR EL DESCUENTRO
                ;
                  }
            $invoice->setDetails($items)
                ->setLegends([
                        (new Legend())
                        ->setCode('1000')
                        ->setValue('SON TRESCIENTOS TREINTA Y SEIS CON OO/100 SOLES')
                ]);    
            $see = $util->getSee(SunatEndpoints::FE_BETA);
            $res = $see->send($invoice);
            $util->writeXml($invoice, $see->getFactory()->getLastXml());
               h::response()->format = \yii\web\Response::FORMAT_JSON;   
                    
         
                if (!$res->isSuccess()) {
                            $error=$res->getError();
                            $errores=[
                                'code'=>$error->getCode(),
                                'message'=>$error->getMessage()
                                ];
                            $transaccion=$model->getDb()->beginTransaction();
                            //;
                           
                            if($model->setRejectedSunat()->save() &&                           
                               $model->storeSend($errores,false)){
                                
                                $transaccion->commit();
                                \yii::error($model->setRejectedSunat()->save());
                                \yii::error($model->storeSend($errores,false));
                                \yii::error('Hizo commit');
                            }else{
                                \yii::error($model->setRejectedSunat()->save());
                                \yii::error($model->storeSend($errores,false));
                                \yii::error('Hizo rollback');
                                $transaccion->rollback();
                                //var_dump($model->setRejectedSunat()->save(),$model->storeSend($errores,false));
                            
                                return ['error' =>\yii::t('base.errors','There were some errors before send, please fix them, and try again')];   
                            }
                            //var_dump($res->getError());
                            return ['error' =>\yii::t('base.errors','There are some errors')];  
                        //echo $util->getErrorResponse($res->getError());
                    }else{
                         /**@var $res BillResult*/
                            $cdr = $res->getCdrResponse();
                            $util->writeCdr($invoice, $res->getCdrZip());
                            $cdrArray=[
                                'id'=>$cdr->getId(),
                                'code'=>$cdr->getCode(),
                                'description'=>$cdr->getDescription(),
                                'notes'=>$cdr->getNotes(),
                            ];
                            $transaccion=$model->getDb()->beginTransaction();
                             //var_dump($model->setRejectedSunat()->save(),$model->storeSend($cdrArray,false));
                           
                             if($model->setPassedSunat()->save() &&                           
                               $model->storeSend($cdrArray,true)){
                                $transaccion->commit();
                            }else{
                                $transaccion->rollback();                                
                                return ['error' =>\yii::t('base.errors','There were some errors before send, please fix them, and try again')];  
                            }                            
                             return ['success' =>' -  '.\yii::t('base.errors','The document was send successfully')]; 
                    }

               
    }
     
  public function actionAjaxSendSumVouchers($id){
         require __DIR__ . '/../envio/vendor/autoload.php'; 
            $util=Util::getInstance();
            $model= \frontend\modules\com\models\ComCajadia::findOne($id);            
             $sum = $model->createVouchersGreenter();
             $sum->setCorrelativo(SunatSendSumary::correlSend());
             
            // var_dump($sum->getDetails());die();                
            $see = $util->getSee(SunatEndpoints::FE_BETA);
            $res = $see->send($sum);
            $util->writeXml($sum, $see->getFactory()->getLastXml());
            h::response()->format = \yii\web\Response::FORMAT_JSON;   
            /*
             * En el caso de que falle el envio
             */
            if (!$res->isSuccess()) {   
                 $error=$res->getError();
                            $errores=[
                                'code'=>$error->getCode(),
                                'message'=>$error->getMessage()
                                ];
                
                //$transaccion=$model->getDb()->beginTransaction();
                  $model->setRejectedSunat()->save();                           
                  $model->storeSend($errores,false,null,null);
                  
                   return ['error' =>\yii::t('base.errors','There are some errors')];    
                
             }

             /*
             * En el caso de que responda con un ticket
              * Verificamos el estado del ticket
             */
            /**@var $res SummaryResult*/
            $ticket = $res->getTicket();
            //echo 'Ticket :<strong>' . $ticket .'</strong>';

             
            $res = $see->getStatus($ticket);
        if (!$res->isSuccess()) {
                //echo $util->getErrorResponse($res->getError());
                $error=$res->getError();
                            $errores=[
                                'code'=>$error->getCode(),
                                'message'=>$error->getMessage()
                                ];
                      // var_dump($errores);die();
               $model->storeSend($errores,false,null,$ticket);
                $model->setRejectedSunat()->save(); 
                $model->setPassToVouchers(ComFactura::ST_REJECT_SUNAT);
                 return ['error' =>\yii::t('base.errors','There are some errors')]; 
           }else{
               $cdr = $res->getCdrResponse();
                $util->writeCdr($sum, $res->getCdrZip());
                $cdrArray=[
                                'id'=>$cdr->getId(),
                                'code'=>$cdr->getCode(),
                                'description'=>$cdr->getDescription(),
                                'notes'=>$cdr->getNotes(),
                            ];
                $model->storeSend($cdrArray,true,$sum->getName(),$ticket);
                $model->setPassedSunat()->save();
                 $model->setPassToVouchers(ComFactura::ST_PASSED_SUNAT);
               return ['success' =>' -  '.\yii::t('base.errors','The summary was send successfully')]; 
                   
               // $util->showResponse($sum, $cdr); 
        }           
            die();               
    }
}

<?php

namespace frontend\modules\mat\controllers;

use Yii;
use frontend\modules\mat\models\MatPetoferta;
use frontend\modules\mat\models\MatVwPetofertaSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use frontend\modules\mat\models\MatDetpetoferta;
use yii\base\Model;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * PetofertaController implements the CRUD actions for MatPetoferta model.
 */
class PetofertaController extends baseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MatPetoferta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MatVwPetofertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MatPetoferta model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MatPetoferta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MatPetoferta();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    
  public function actionCreatePetOferta()
    {
       
        $model = new MatPetoferta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->codocu]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }  
    
  public function actionCreaPetOferta(){ 
        
        $model = new MatPetoferta();
        $request = Yii::$app->getRequest();       
         $models =[new MatDetpetoferta()];// $this->getItemsOvdet();//Obenter los items detalles
           
        /*
         * Validacion ajax 
         */
        // var_dump($request->isAjax); die();
        if ($request->isPost && $request->post('ajax') !== null) {
            yii::error('VALIDACION AJAX');
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                 $data = Yii::$app->request->post('MatDetpetoferta', []);               
                    foreach (array_keys($data) as $index) {
                     $models[$index] = new \frontend\modules\mat\models\MatDetpetoferta();
                        }
                    Model::loadMultiple($models, Yii::$app->request->post());
                      $model->load($this->request->post());
                    $result = ActiveForm::validate($model);                      
                     if(count($result)==0){ //Si el encabezado va bien en todo
                        if(count($data)==0){
                             $result[\yii\helpers\Html::getInputId($model,'nombre_cliente')] = [yii::t('base.errors','No child records have been registered')];
                             return $result;
                         }
                      $result = ActiveForm::validateMultiple($models); 
                        return $result;
                     }else{
                         return $result;  
                     }           
        }
        
         if ($this->request->isPost) {  
             // VAR_DUMP($this->request->post(),$model->attributes);
            // DIE();
            if ($model->load($this->request->post()) && $model->save()) {
                 $model->refresh();
                 $data = Yii::$app->request->post('MatDetpetoferta', []);
                    foreach (array_keys($data) as $index) {
                     $models[$index] = new MatDetpetoferta();
                        }
                if(Model::loadMultiple($models, Yii::$app->request->post())){
                      $item=100;
                    foreach($models as $modeldetalle){
                          $modeldetalle->petoferta_id=$model->id;
                        /*$modeldetalle->setIdChild($model->id)
                                ->setItem($item.'')->
                                setTipoDocSunat($model->sunat_tipodoc)-> //Boleta o factura
                                setTipoTributoIGV() //Tiene IGV
                                ->setTipoAfectacionEsGravada(); //  Es gravada  (Puede ser exonerada, pero tiene que indicarlo el usuario)                   
                       */ if(!$modeldetalle->save()){
                            yii::error($modeldetalle->getErrors(),__FUNCTION__);
                        }
                       $item++;
                    }
                     //$model->refreshValues(); 
                     yii::error('attributos del modelo');
                     yii::error($model->attributes);
                      // $model->preparePdfInvoice();  
                     
                       
                     return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    var_dump(Model::loadMultiple($models, Yii::$app->request->post()));die();
                }                
            }else{
                var_dump($model->attributes);
                print_r($model->getErrors()); die();
            }
        } else { 
            
        }       
        return $this->render('create', ['model' => $model,'items' => $models]);
    }
    
    
    
    /**
     * Updates an existing MatPetoferta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdatePetOferta($id)
    {
        $model = $this->findModel($id);
        $models=$model->matDetpetoferta;
        $request = Yii::$app->getRequest();   
        if ($request->isPost && $request->post('ajax')!== null) {
            $models=[];
             h::response()->format = \yii\web\Response::FORMAT_JSON;
                 $data = Yii::$app->request->post('MatDetpetoferta', []); 
                 $idsModels= array_column($data,'id');
                 $models=$model->getMatDetpetoferta()->andWhere(['in','id',$idsModels])->all();                   
                   
                 
                 /*
                  * Verificando los items que se agregaron
                  */
                    foreach($data as $index=>$dato){
                        if(empty($dato['id'])){
                            $modelTemp=New MatDetpetoferta();
                            $modelTemp->setAttributes($dato);
                            $modelTemp->petoferta_id=$id;
                            $models[]=$modelTemp;                            
                        }
                            
                    }
                 
                 /*
                  * Fin de la verificacion de items agregados
                  */
                    
                    
                  /****************************************
                  * De los items que se borraron hay que eliminarlos
                  ******************************************/
                    MatDetpetoferta::deleteAll([ 'and',['petoferta_id'=>$model->id],['not in','id',$idsModels]]);
                    
                 /************************************ */
                 
                 
                 Model::loadMultiple($models, Yii::$app->request->post());
                      $model->load($this->request->post());
                    $result = ActiveForm::validate($model);                      
                     if(count($result)==0){ //Si el encabezado va bien en todo
                        if(count($data)==0){///si borro todos los items no permitirlo
                             $result[\yii\helpers\Html::getInputId($model,'nombre_cliente')] = [yii::t('base.errors','No child records have been registered')];
                             return $result;
                         }
                        $result = ActiveForm::validateMultiple($models); 
                        return $result;
                     }else{
                         return $result;  
                     }           
        }
        
        if ($this->request->isPost) {  
            $models=[];
             if ($model->load($this->request->post()) && $model->save()) {
                 yii::error('PASANDO EL SAVE ',__FUNCTION__);
                  yii::error('EL POST ',__FUNCTION__);
                  yii::error(Yii::$app->request->post(),__FUNCTION__);
                   $data = Yii::$app->request->post('MatDetpetoferta', []); 
                 $idsModels= array_column($data,'id');
                 $models=$model->getMatDetpetoferta()->andWhere(['in','id',$idsModels])->all();                   
                   
                 
                 /*
                  * Verificando los items que se agregaron
                  */
                    foreach($data as $index=>$dato){
                        if(empty($dato['id'])){
                            $modelTemp=New MatDetpetoferta();
                            $modelTemp->setAttributes($dato);
                            $modelTemp->petoferta_id=$id;
                            $models[]=$modelTemp;                            
                        }
                            
                    }
                 
                 /*
                  * Fin de la verificacion de items agregados
                  */
                    
                    
                  /****************************************
                  * De los items que se borraron hay que eliminarlos
                  ******************************************/
                     MatDetpetoferta::deleteAll([ 'and',['petoferta_id'=>$model->id],['not in','id',$idsModels]]);
                 
                 /************************************ */
                 
                if(Model::loadMultiple($models, Yii::$app->request->post()) && $model->isNewRecord){
                     yii::error('Funciono el LoadMultilpe ',__FUNCTION__);
                      $item=100;
                    foreach($models as $modeldetalle){
                          //$modeldetalle->petoferta_id=$model->id;
                        yii::error($modeldetalle->attributes);
                       if(!$modeldetalle->save()){
                            yii::error($modeldetalle->getErrors(),__FUNCTION__);
                        }
                       $item++;
                    }
                      yii::error('attributos del modelo');
                     yii::error($model->attributes);
                      return $this->redirect(['view', 'id' => $model->id]);
                }/*else{
                    var_dump(Model::loadMultiple($models, Yii::$app->request->post()),Yii::$app->request->post(),$models);die();
                } */               
            }else{
                var_dump($model->attributes);
                print_r($model->getErrors()); die();
            }
        } else { 
            $models=$model->matDetpetoferta;
            
        }       
        return $this->render('update', ['model' => $model,'items' => $models]);
    }
    
    
    public function actionEditPetOferta($id){
        $model = $this->findModel($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,'items'=>[],
        ]);
        
    }

    /**
     * Deletes an existing MatPetoferta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MatPetoferta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MatPetoferta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MatPetoferta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    
   public function actionModalEditDet($id){
    $this->layout = "install"; 
      $modeldet=\frontend\modules\mat\models\MatDetpetoferta::findOne($id);      
       $datos=[];
        if(h::request()->isPost){            
            $modeldet->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($modeldet);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $modeldet->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$modeldet->id];
            }
        }else{
           return $this->renderAjax('modal_edit_pet', [
                        'model' => $modeldet,
                        'id' => $id,                       
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
   } 
   
    public function actionClonePetOferta($id)
    {
        $modelModel = $this->findModel($id);
        if(is_null($modelModel))
            throw new NotFoundHttpException(Yii::t('base.errors', 'No se encontró el registro.'));
        if(!$modelModel->isClonable())
            throw new NotFoundHttpException(Yii::t('base.errors', 'El registro no es clonable'));
       
        
        $model=New MatPetoferta();
            $model->setScenario($model::SCE_CLONE);
            $model->setAttributes(['fecha'=>$model::SwichtFormatDate($model::CarbonNow()->format('Y-m-d'), 'date', true),]);
           
        if(h::request()->isPost){ 
            yii::error(h::request()->post(),__FUNCTION__);
            $post=h::request()->post();
            if (h::request()->isAjax && $model->load($post)) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $transaccion=$model->getDb()->beginTransaction();
            if($model->clonePetoferta($modelModel)){
                $model->fecha=$post['MatPetoferta']['fecha'];
                $model->codpro=$post['MatPetoferta']['codpro'];
                /*****
                 * Amarrando
                 */
                $model->id_relacionado=$modelModel->id;
                $modelModel->id_relacionado= $modelModel->id;
                /*
                 * Terminando de amarrar
                 */
                
                $model->save();
                $modelModel->save();
                $transaccion->commit();
                return $this->redirect(['update-petoferta', 'id' => $model->id]);
            }else{
               $transaccion->rollBack();
               throw new NotFoundHttpException(Yii::t('base.errors', 'No se pudo clonar, hay algunos errores.'));
            }
        }else{
             return $this->render('update_clone', ['model' => $model,'padre'=>$modelModel]);
        }
        
        
    }
    
    public function actionAjaxAddItem($id){
        if (h::request()->isAjax) {
           
            $idPetoferta=h::request()->post('idpet');
            yii::error($idPetoferta,__FUNCTION__);
            h::response()->format = yii\web\Response::FORMAT_JSON;  
            $model = \common\models\masters\Maestrocompo::findOne($id);
           yii::error($model,__FUNCTION__);
            
            if(is_null($model))
           return ['error'=>yii::t('base.errors','El registro no existe')];
            
            $modeloDetalle=New MatDetpetoferta();
            $modeloDetalle->setAttributes([
                        'codart'=>$model->codart,
                        'codum'=>$model->codum,                        
                        'descripcion'=>$model->descripcion,
                        'cant'=>1, 
                         'petoferta_id'=>$idPetoferta,
                    ]);
            yii::error($modeloDetalle->attributes,__FUNCTION__);
            if(!$modeloDetalle->save()){
                yii::error($modeloDetalle->getErrors(),__FUNCTION__);
                return ['error'=>yii::t('base.errors',$model->getFirstError())];   
            }else{
                return ['success'=>yii::t('base.errors','Se agregó el item')];
            }
             
            
         }    
    }
    
    
    public function actionMakePdf($id){
        $this->layout="reportes";
        $rutaTemporal = \yii::getAlias('@temp');
        $nombre= uniqid().'.pdf';
        $model=$this->findModel($id);
        $contenido=$this->render('reporte_peti',['model'=>$model]); 
        $pdf=$this->preparePdf($contenido);
       // $pdf->WriteHTML($contenido);
        $pdf->Output($rutaTemporal .'/'. $nombre, \Mpdf\Output\Destination::INLINE);
        
    }
    
     private function preparePdf($contenidoHtml) {
        //  $contenidoHtml = \Pelago\Emogrifier\CssInlinerCssInliner::fromHtml($contenidoHtml)->inlineCss()->render();
        //->renderBodyContent(); 
        $mpdf = self::getPdf();
        // $mpdf->SetHeader(['{PAGENO}']);
        $mpdf->margin_header = 1;
        $mpdf->margin_footer = 1;
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';

        /*$stylesheet = file_get_contents(\yii::getAlias("@frontend/web/css/bootstrap.min.css")); // external css
        $stylesheet2 = file_get_contents(\yii::getAlias("@frontend/web/css/reporte.css")); // external css
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($stylesheet2,1);*/

        /*$mpdf->DefHTMLHeaderByName(
                'Chapter2Header', $this->render("/citas/reportes/cabecera")
        );*/
        //$mpdf->DefHTMLFooterByName('pie',$this->render("/citas/reportes/footer"));
        //$mpdf->SetHTMLHeaderByName('Chapter2Header');
        // $contenidoHtml = \Pelago\Emogrifier\CssInliner::fromHtml($contenidoHtml)->inlineCss($stylesheet)->render();
        $mpdf->WriteHTML($contenidoHtml);
        return $mpdf;
    }
 public static function  getPdf(){
               $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'fontDir' => array_merge($fontDirs,[
                Yii::getAlias('@fonts')
                    ]),
    'fontdata' => $fontData + [
        'cour' => [
            'R' => 'Courier.ttf',
            
        ],
        /*'helvetica' => [
            'R' => 'Helvetica.ttf',
            'I' => 'VerdanaBOLD.ttf',
        ],*/
        /*'verdana' => [
            'R' => 'Verdana.ttf',
            'B' => 'VerdanaBOLD.ttf',
        ],*/
        
    ],
    //'default_font' => 'cour'
]);
//print_r($mpdf->fontdata);die();
          
          //$mpdf=new \Mpdf\Mpdf();
          //echo get_class($mpdf);die();
          /* $pdf->methods=[ 
           'SetHeader'=>[($model->tienecabecera)?$header:''], 
            'SetFooter'=>[($model->tienepie)?'{PAGENO}':''],
        ];*/
           
                  
           $mpdf->simpleTables = false;
            $mpdf->packTableData = true;
           //$mpdf->showImageErrors = true;
           //$mpdf->curlAllowUnsafeSslRequests = true; //Permite imagenes de url externas
         return $mpdf;
    }
}

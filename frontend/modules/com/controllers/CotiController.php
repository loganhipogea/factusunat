<?php

namespace frontend\modules\com\controllers;
use common\helpers\h;
use common\models\masters\Centros;
use common\models\masters\VwSociedades;
use common\filters\FilterCurrentCenter;
use frontend\modules\com\models\ComCotizacion;
use frontend\modules\com\models\ComCotizacionSearch;
use frontend\modules\com\models\ComDetcoti;
use frontend\modules\com\models\ComDetcotiSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\date\DatePicker;
use yii\base\Model;
use yii\widgets\ActiveForm;
use yii\web\Response;
use common\controllers\base\baseController;
use yii;
/**
 * ComController implements the CRUD actions for ComOv model.
 */
class CotiController extends baseController
{
    
    public $nameSpaces = ['frontend\modules\com\models'];
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'filterCenter' => [
                    'class' =>FilterCurrentCenter::className(),
                    
                ],
            ]
        );
    }

    /**
     * Lists all ComOv models.
     *
     * @return string
     */
    public function actionIndexCoti()
    {
        $searchModel = new ComCotizacionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index_coti', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ComOv model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewCoti($id)
    {
        return $this->render('view_coti', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ComOv model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ComCotizacion();
       $models=[];
        if ($this->request->isPost) {
           
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view-coti', 'id' => $model->id]);
            }
        } else {
            
        }

        return $this->render('create_coti', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ComOv model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateCoti($id)
    {
        $model = $this->findModel($id);
        $searchModel = new ComDetcotiSearch();
        $providerItems = $searchModel->search($this->request->queryParams);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view-coti', 'id' => $model->id]);
        }

        return $this->render('update_coti', [
            'model' => $model,
            'providerItems'=>$providerItems,
            'searchModel'=>$searchModel,
        ]);
    }

    /**
     * Deletes an existing ComOv model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ComOv model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ComOv the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComCotizacion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('base.names', 'The requested page does not exist.'));
    }
    
  
   
     public function actionCreaOvPlus(){ 
         \frontend\modules\sunat\models\SunatAccess::pwd();
        $model = new ComFactura();
        $request = Yii::$app->getRequest();
        /*
         * Colocando valores por default en ComFactura
         */
         $model->setAttributes([
            'codcen'=> Centros::codcen(),
            'codsoc'=> VwSociedades::codsoc(),
            'sunat_tipodoc'=> h::sunat()->graw('s.01.tdoc')->g('BOLETA'),
            'sunat_tipdoccli'=> h::sunat()->graw('s.06.tdociden')->g('DNI'),
            'codmon'=>h::gsetting('general','moneda'),
            'caja_id'=> MyModule::idCajaDia(Centros::codcen()),
        ]);
        //}
       
        //$model->setScenario($model::SCE_CREACION_RAPIDA);
         $models =[];// $this->getItemsOvdet();//Obenter los items detalles
       
        
        
        /*
         * Validacion ajax 
         */
        if ($request->isPost && $request->post('ajax') !== null) {
            yii::error('VALIDACION AJAX');
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                //return \yii\widgets\ActiveForm::validate($model);
                 $data = Yii::$app->request->post('ComFactudet', []);
               
                    foreach (array_keys($data) as $index) {
                     $models[$index] = new \frontend\modules\com\models\ComFactudet();
                        }
                     //$modelsNuev=$models;
                   // array_push($modelsNuev,$model);
                         
                     Model::loadMultiple($models, Yii::$app->request->post());
                       //yii::error('validando la cabecera');
                     $model->load($this->request->post());
                     //if(count($data)==0){
                    //$model->addError('numero',yii::t('base.errors','No child records have been registered'));
                     //} 
                     $result = ActiveForm::validate($model);
                      
                     if(count($result)==0){ //Si el encabezado va bien en todo
                     //Verificamos que se haya registrado por lo meno un hijo
                         
                         if(count($data)==0){
                             $result[\yii\helpers\Html::getInputId($model,'nombre_cliente')] = [yii::t('base.errors','No child records have been registered')];
                              //$result['codsoc-numero']=yii::t('base.errors','No child records have been registered');
                              return $result;
                         }
                     
                         //Entonces recien podemos mostrar los erroes del detalle
                         
                        $result = ActiveForm::validateMultiple($models); 
                        return $result;
                     }else{
                         return $result;  
                     }
                   // $result = ActiveForm::validateMultiple($models);
                  
                    //
                    //    //yii::error('validando_el modelo',__FUNCTION__);
                    //yii::error(ActiveForm::validate($model));
                   //array_push($result,ActiveForm::validate($model));
                                  
        }
        
         if ($this->request->isPost) {           
            if ($model->load($this->request->post()) && $model->save()) {
                 $model->refresh();
                 $data = Yii::$app->request->post('ComFactudet', []);
                    foreach (array_keys($data) as $index) {
                     $models[$index] = new \frontend\modules\com\models\ComFactudet();
                        }
                if(Model::loadMultiple($models, Yii::$app->request->post())){
                      $item=100;
                    foreach($models as $modeldetalle){
                        $modeldetalle->setIdChild($model->id)
                                ->setItem($item.'')->
                                setTipoDocSunat($model->sunat_tipodoc)-> //Boleta o factura
                                setTipoTributoIGV() //Tiene IGV
                                ->setTipoAfectacionEsGravada(); //  Es gravada  (Puede ser exonerada, pero tiene que indicarlo el usuario)                   
                        if(!$modeldetalle->save()){
                            yii::error($modeldetalle->getErrors(),__FUNCTION__);
                        }
                       $item++;
                    }
                     $model->refreshValues(); 
                     yii::error('attributos del modelo');
                     yii::error($model->attributes);
                       $model->preparePdfInvoice();  
                     
                       
                     return $this->redirect(['view-invoice', 'id' => $model->id]);
                }else{
                    var_dump(Model::loadMultiple($models, Yii::$app->request->post()));die();
                }                
            }else{
                var_dump($model->attributes);
                print_r($model->getErrors()); die();
            }
        } else { 
            
        }       
        return $this->render('create_plus', ['model' => $model,'models' => $models]);
    }
    
     public function actionAjaxShowStock(){       
        if (h::request()->isAjax) {
            $val=h::request()->post('valorInput');
            if(strlen($val)>2)
            return $this->renderAjax('listado_stock',['parametro'=>$val]);
            
         }     
   }
   
   public function actionAjaxAddArt($id){       
        if (h::request()->isAjax) {
            //$id=h::request()->get('valorInput');
           // var_dump($val);die();
            $model = \frontend\modules\logi\models\LogiVwStock::find()->andWhere(['id'=>$id])->one();
             h::response()->format = yii\web\Response::FORMAT_JSON;  
             return [$model->attributes];
            
         }     
   }
    
  private function getItemsOvdet(){
      

        $items =[]; 
           $attributes=[
            'item'=>'100',
             'codsoc'=>'A',
             'codart'=>'100155',
             'codcen'=>'3207',
             'codal'=>'1203',
            'codum'=>'UN',
            ];
            $item1=new \frontend\modules\com\models\ComOvdet();
            $item1->setAttributes($attributes);
            $item2=new \frontend\modules\com\models\ComOvdet();
            $item2->setAttributes($attributes);
           
            $items[] = $item1;
            $items[] = $item2;
        
        return $items;
  }
  
  
  public function actionUpdateInvoice($id)
    {
        $model = \frontend\modules\com\models\ComFactura::findOne($id);
        $request=h::request();
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                 $result = ActiveForm::validate($model);
                    return $result;                
        }
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view-invoice', 'id' => $model->id]);
        }

        return $this->render('update_factura', [
            'model' => $model,
        ]);
        
    }
    
    public function actionViewInvoice($id)
    {
        $this->layout = "install";
        return $this->render('view', [
            'model' => \frontend\modules\com\models\ComFactura::findOne($id),
        ]);
    }
    
    
     public function actionOpenCash(){
        $model=New \frontend\modules\com\models\ComCajadia();
        $model->fecha=$model::currentDateInFormat();
        $model->setCreated();
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
       

        if (h::request()->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            //$model->refresh();
            //h::session()->set(MyModule::SESSION_ID_CURRENT_CASH,$model->id);
            
            return $this->redirect(['index-cashes']);
        }ELSE{
            //print_r($model->getErrors());DIE();
        }
    
        return $this->render('create_caja_dia', [
            'model' => $model,
        ]);
    }
    
    public function actionEditDetailInvoice($id) {
        //var_dump(\yii\helpers\Json::decode(h::request()->get('gridName')));die();

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $model= ComFactudet::findOne($id);
        
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                /*print_r(h::request()->post());
               print_r($model->attributes);die();*/
               if(!$model->save()) print_r($model->getErrors()); 
                
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->codcen];
            }
        }else{
           return $this->renderAjax('modal_detalle_factura', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    public function actionNewDetailInvoice($id) {
        //var_dump(\yii\helpers\Json::decode(h::request()->get('gridName')));die();
        $modelParent= ComFactura::findOne($id);
        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $model=New ComFactudet();
        $model->setIdChild($modelParent->id); 
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                /*print_r(h::request()->post());
               print_r($model->attributes);die();*/
               if(!$model->save()) print_r($model->getErrors()); 
                
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->codcen];
            }
        }else{
           return $this->renderAjax('modal_detalle_factura', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
   public function actionAjaxDeleteInvoiceItem($id){
       //verificamos el estado
       $model=ComFactudet::findOne($id);
       h::response()->format = yii\web\Response::FORMAT_JSON;            
                 
        if(!$model->factura->isCreated()){
           return ['error' => yii::t('base.errors', 'Document status does not allow editing')];
                
        }elseif($model->factura->getDetails()->count()<2){//INTENTA BORRAR EL ULTIMO ITEM 
           return ['error' => yii::t('base.errors', 'Can\'t delete the last item')];
            
        }else{
          return parent::deleteModel($id,$model::className());
        }
   }
   
   public function actionAjaxPassInvoice($id){
       //verificamos el estado
       $model=ComFactura::findOne($id);
       h::response()->format = yii\web\Response::FORMAT_JSON;   
         if(!$model->passInvoice()){ //En la funcion passInvoice validar el cambio de estado
           return ['error' => $model->getFirstError()];             
         }else{
           return ['success' => yii::t('base.errors','Document was passed' )];  
         }
        
        
   }
   
   public function actionAjaxRemoveInvoice($id){
       //verificamos el estado
       $model=ComFactura::findOne($id);
       h::response()->format = yii\web\Response::FORMAT_JSON;   
         if(!$model->removeInvoice()){ //En la funcion  validar el cambio de estado
           return ['error' => $model->getFirstError()];             
         }else{
           return ['success' => yii::t('base.errors','Document was passed' )];  
         }
        
        
   }
   
  public function actionIndexInvoicesSimple(){
      $searchModel = new \frontend\modules\com\models\ComFacturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_simple', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
  }
  
  public function actionIndexInvoices(){
      $searchModel = new ComVwFactudetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_con_detalles', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
  }
  
  
  public function actionIndexCashes()
    {
      
        $searchModel = new \frontend\modules\com\models\ComCajadiaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index_cashes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
 public function actionUpdateCashday($id)
    {
        $model = \frontend\modules\com\models\ComCajadia::findOne($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index-cashes', 'id' => $model->id]);
        }else{
            //print_r($model->getErrors());die();
        }            

        return $this->render('update_caja_dia', [
            'model' => $model,
        ]);
    }
    
    public function actionTestPdf($id){
       $model= ComFactura::findOne($id);
       $model->preparePdfInvoice();
       //$this->render('test_pdf',['model'=>$model]);
    }
    
     public function actionCreateMaterial() {

         $this->layout = "install";
         $model=New Maestrocompo();
         $model->setScenario($model::SCE_PTO_VENTA);
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            yii::error(h::request()->post());
            yii::error($model->attributes);
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   //$model->createStock('1203');
                   
                  return ['success'=>1,'campos'=>$model->attributes];  
                }else{
                    
                }                
            }
        }else{
           return $this->renderAjax('modal_stock', [
                        'model' => $model,
                        //'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
   public function actionAjaxCloseCash($id){       
        if (h::request()->isAjax) {
            //$id=h::request()->get('valorInput');
           // var_dump($val);die();
            $model = ComCajadia::findOne($id);
            $model->setPassed()->refreshAmounts()->save();
             h::response()->format = yii\web\Response::FORMAT_JSON;  
             return ['success'=>yii::t('base.errors','Cash was closed successfully')];
            
         }     
   }
   
   public function actionAjaxExpandAttachments(){
     
    if (isset($_POST['expandRowKey'])) {
        $model = ComFactura::findOne($_POST['expandRowKey']+0);
         return $this->renderPartial('view_attachments', ['model'=>$model]);
        
        
    } 

  }
  
  
  public function actionModalNewGrupoCoti($id) {
         $modelPadre=$this->findModel($id);         
         $this->layout = "install";
         $model=New \frontend\modules\com\models\ComCotigrupos(); 
         $model->coti_id=$id;
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   //$model->createStock('1203');
                   
                  return ['success'=>1];  
                }else{
                    
                }                
            }
        }else{
           return $this->renderAjax('modal_coti_grupo', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
   public function actionModalEditGrupoCoti($id) {

         $this->layout = "install";
         $model= \frontend\modules\com\models\ComCotigrupos::findOne($id);
         //$model->setScenario($model::SCE_PTO_VENTA);
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   //$model->createStock('1203');
                   
                  return ['success'=>1];  
                }else{
                    
                }                
            }
        }else{
           return $this->renderAjax('modal_coti_grupo', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
   public function actionModalNewGrupoCeco($id) {
         $modelPadre=$this->findModel($id);         
         $this->layout = "install";
         $model=New \frontend\modules\com\models\ComCoticeco(); 
         $model->coti_id=$id;
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   //$model->createStock('1203');
                   
                  return ['success'=>1];  
                }else{
                    
                }                
            }
        }else{
           return $this->renderAjax('modal_ceco_grupo', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
   public function actionModalEditGrupoCeco($id) {

         $this->layout = "install";
         $model= \frontend\modules\com\models\ComCoticeco::findOne($id);
         //$model->setScenario($model::SCE_PTO_VENTA);
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   //$model->createStock('1203');
                   
                  return ['success'=>1];  
                }else{
                    
                }                
            }
        }else{
           return $this->renderAjax('modal_ceco_grupo', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
  public function actionDetailMatByCeco($id){
     $model=$this->findModel($id);
     $id_ceco=h::request()->get('cecoid');
     //$id_partida=h::request()->get('partid');
     if(is_null($modelCeco= \frontend\modules\com\models\ComCoticeco::findOne($id_ceco)))
     throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el ceco id'));
     /*if(is_null($modelCeco= \frontend\modules\com\models\ComCotigrupos::findOne($id_partida)))
     throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el ceco id'));
     */
     return $this->render('detalle_by_ceco',['modelCoti'=>$model,'model'=>$modelCeco]);
     
     
     
      
  }  
  
 
  public function actionModalNewDetailByCeco($id) {
         $modelPadre=$this->findModel($id);         
         $this->layout = "install";
         $id_ceco=h::request()->get('cecoid');
         if(h::request()->isGet && is_null($modelCeco= \frontend\modules\com\models\ComCoticeco::findOne($id_ceco)))
        throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el ceco id'));
      $model=New \frontend\modules\com\models\ComDetcoti(); 
         $model->coti_id=$id+0;
         $model->coticeco_id=$id_ceco;
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            yii::error($model->attributes,__FUNCTION__);
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   //$model->createStock('1203');
                   
                  return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax('modal_detail_by_ceco', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    public function actionModalEditDetailByCeco($id) {

         $this->layout = "install";
         $model= \frontend\modules\com\models\ComDetcoti::findOne($id);
         //var_dump($model);die();
         //$model->setScenario($model::SCE_PTO_VENTA);
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   //$model->createStock('1203');
                   
                  return ['success'=>1];  
                }else{
                    
                }                
            }
        }else{
           return $this->renderAjax('modal_detail_by_ceco', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
    public function actionAjaxExpandOferta(){
        if (isset($_POST['expandRowKey'])) {
        $model = ComDetcoti::findOne($_POST['expandRowKey']+0);
         return $this->renderPartial('ajax_expand_oferta', ['model'=>$model]);
        
        
    }  
    }
    
    public function actionDetailMatByPartida($id){
     $model=$this->findModel($id);
     $id_partida=h::request()->get('partida_id');
     
      if ($this->is_editable()){
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            return $this->editField();
           } 
     //$id_partida=h::request()->get('partid');
     if(is_null($modelPartida= \frontend\modules\com\models\ComCotigrupos::findOne($id_partida)))
     throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el ceco id'));
     /*if(is_null($modelCeco= \frontend\modules\com\models\ComCotigrupos::findOne($id_partida)))
     throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el ceco id'));
     */
     return $this->render('detalle_by_partida',['modelCoti'=>$model,'model'=>$modelPartida]);
     
   }
   
   public function actionModalNewDetailByPartida($id) {
         $this->layout = "install";
         $modelCoti= $this->findModel($id);
         $model=new  \frontend\modules\com\models\ComDetcoti();
         $model->cotigrupo_id=h::request()->get('partida_id');
         $model->coti_id=$id;
         //var_dump($model);die();
         //$model->setScenario($model::SCE_PTO_VENTA);
         $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   //$model->createStock('1203');
                   
                  return ['success'=>1];  
                }else{
                    
                }                
            }
        }else{
           return $this->renderAjax($this->swichtRender(), [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
    
   public function actionModalNewDetailTrabajoByPartida($id) {
         $this->layout = "install";
         $modelCoti= $this->findModel($id);
         $model=new \frontend\modules\com\models\ComDetcotiManoObra();
         $model->cotigrupo_id=h::request()->get('partida_id');
         $model->coti_id=$id;
          $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax('modal_detail_trabajo_by_partida', [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
    }
    
    
   private function swichtRender($modo='default'){     
        switch ($modo) {
    case 'default':
        return 'modal_detail_material_by_partida';
        break;
    case ComDetcoti::SCE_HERRAMIENTAS:
        return 'modal_detail_herram_by_partida';
        break;
    case ComDetcoti::SCE_MANO_OBRA:
        return 'modal_detail_trabajo_by_partida';
        break;
    case ComDetcoti::SCE_SERVICIO:
        return 'modal_detail_serv_by_partida';
        break;
        }
       
   }
   
   
  public function actionModalNewDetcotiByPartida($id) {
         $this->layout = "install";
         $modelPadre= \frontend\modules\com\models\ComCotiDet::findOne($id);
         $model=new \frontend\modules\com\models\ComDetcoti();
         if(h::request()->isGet){
             $model->cotigrupo_id=h::request()->get('partida_id');
             $model->tipo=h::request()->get('tipo');
             
         }
             $model->detcoti_id=$modelPadre->id;
             $model->coti_id=$modelPadre->coti_id;
             $model->coticeco_id=$modelPadre->coticeco_id;
    
         $model->resolveScenario();
         $model->punit=1;
         
        
         
          $datos=[];
        if(h::request()->isPost){  
            yii::error(h::request()->post(),__FUNCTION__);
            $model->load(h::request()->post()); 
            yii::error($model->attributes,__FUNCTION__);
            
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax(
                 //RENDERIZANDO LA VISTA SEGUN EL ESCENARIO DEL MODELO
                   $this->swichtRender($model->getScenario()),
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
    }
     
  public function actionModalEditDetcotiByPartida($id) {
         $this->layout = "install";        
         $model=\frontend\modules\com\models\ComDetcoti::findOne($id);        
         $model->resolveScenario();
        
          $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax(
                 //RENDERIZANDO LA VISTA SEGUN EL ESCENARIO DEL MODELO
                   $this->swichtRender($model->getScenario()),
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
    } 
    
   public function actionModalNewDetpadreByPartida($id){
       $this->layout = "install";
         $modelPartida= \frontend\modules\com\models\ComCotigrupos::findOne($id);
         $model=new \frontend\modules\com\models\ComCotiDet();
         $model->coti_id=$modelPartida->coti_id;
         $model->cotigrupo_id=$modelPartida->id;
         //print_r($model->attributes);
          $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax(
                 'modal_detpadre_by_partida',
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
   } 
    
    public function actionModalEditDetpadreByPartida($id){
       $this->layout = "install";
         $model= \frontend\modules\com\models\ComCotiDet::findOne($id);
        
          $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax(
                 'modal_detpadre_by_partida',
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
   }  
   
   public function actionAjaxDeletePartida($id){
           $model= \frontend\modules\com\models\ComCotigrupos::findOne($id);
            h::response()->format = yii\web\Response::FORMAT_JSON; 
          return parent::deleteModel($id,$model::className());        
   }
   
    public function actionAjaxDeleteColector($id){
           $model= \frontend\modules\com\models\ComCoticeco::findOne($id);
            h::response()->format = yii\web\Response::FORMAT_JSON; 
          return parent::deleteModel($id,$model::className());        
   }
   
   public function actionAjaxDeleteDetalleDetalle($id){
           $model= \frontend\modules\com\models\ComDetcoti::findOne($id);
            h::response()->format = yii\web\Response::FORMAT_JSON; 
          return parent::deleteModel($id,$model::className());        
   }
   
   public function actionAjaxDeleteDetalle($id){
           $model= \frontend\modules\com\models\ComCotiDet::findOne($id);
            h::response()->format = yii\web\Response::FORMAT_JSON; 
          return parent::deleteModel($id,$model::className());        
   }
   
    public function actionAjaxDeleteCargo($id){
           $model= \frontend\modules\com\models\ComCargoscoti::findOne($id);
            h::response()->format = yii\web\Response::FORMAT_JSON; 
          return parent::deleteModel($id,$model::className());        
   }
   
   public function actionAjaxDeleteContacto($id){
           $model= \frontend\modules\com\models\ComContactocoti::findOne($id);
            h::response()->format = yii\web\Response::FORMAT_JSON; 
          return parent::deleteModel($id,$model::className());        
   }
   
   public function actionAjaxAgregaCargos($id){
       $model= ComCotizacion::findOne($id);
       h::response()->format = yii\web\Response::FORMAT_JSON;   
        $model->agregaCargos(); //En la funcion passInvoice validar el cambio de estado
           return ['success' => yii::t('base.messages','Se actualizaron los cargos')];             
         
   }
   
   public function actionModalNewCargoCoti($id){
       $this->layout = "install";
         $modelCoti= \frontend\modules\com\models\ComCotizacion::findOne($id);
         $model=new \frontend\modules\com\models\ComCargoscoti();
         $model->coti_id=$modelCoti->id;
         
          $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax(
                 'modal_cargo',
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
   } 
   
   public function actionModalEditCargoCoti($id){
       $this->layout = "install";
         $model= \frontend\modules\com\models\ComCargoscoti::findOne($id);
        
          $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax(
                 'modal_cargo',
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
   }

 public function actionMakePdf($id){
        $this->layout="reportes";
        $rutaTemporal = \yii::getAlias('@temp');
        $nombre= uniqid().'.pdf';
        $model=$this->findModel($id);
        
        $contenido=$this->render('reporte_coti',['model'=>$model]); 
       
       /* return Yii::$app->html2pdf
    ->convert($contenido)    
    ->send();
        die();*/
        
       //echo $contenido; die();
        $pdf=$this->preparePdf($contenido);
      //  $pdf->WriteHTML($contenido);
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
        $mpdf->setFooter('Página {PAGENO} de {nb}');
        $mpdf->SetWatermarkText('HOLA AMIGUITOS');
        $mpdf->showWatermarkText = true;
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

    public function actionAjaxLoadContactos($id){
       $model= ComCotizacion::findOne($id);
       h::response()->format = yii\web\Response::FORMAT_JSON;   
        $model->loadContactos(); //En la funcion passInvoice validar el cambio de estado
           return ['success' => yii::t('base.messages','Se actualizaron los contactos')];             
         
   }
   
   
   public function actionModalNewContactoCoti($id){
       $this->layout = "install";
         $modelCoti= \frontend\modules\com\models\ComCotizacion::findOne($id);
         $model=new \frontend\modules\com\models\ComContactocoti();
         $model->coti_id=$modelCoti->id;
         
          $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax(
                 'modal_contacto',
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
   } 
   
   public function actionModalEditContactoCoti($id){
       $this->layout = "install";
         $model= \frontend\modules\com\models\ComContactocoti::findOne($id);
        
          $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
           return $this->renderAjax(
                 'modal_contacto',
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
   }
    
   
}

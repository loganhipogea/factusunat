<?php

namespace frontend\modules\com\controllers;
use common\helpers\h;
use common\models\masters\Centros;
use common\models\masters\VwSociedades;
use common\filters\FilterCurrentCenter;
use frontend\modules\com\models\ComOv;
use frontend\modules\com\Module as MyModule;
use frontend\modules\com\models\ComFactudet;
use frontend\modules\com\models\ComFactura;
use common\models\masters\Maestrocompo;
use frontend\modules\com\ComOvSearch;
use frontend\controllers\base\baseController;
use frontend\modules\com\models\ComVwFactudetSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\date\DatePicker;
use yii\base\Model;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii;
/**
 * ComController implements the CRUD actions for ComOv model.
 */
class ComController extends baseController
{
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
    public function actionIndex()
    {
        $searchModel = new ComOvSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
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
    public function actionView($id)
    {
        return $this->render('view', [
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
        $model = new ComOv();
       $models=[];
        if ($this->request->isPost) {
            var_dump($this->request->post());
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,'models' => $models,
        ]);
    }

    /**
     * Updates an existing ComOv model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        if (($model = ComOv::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('base.labels', 'The requested page does not exist.'));
    }
    
    public function actionCreaOv(){ 
        $model = new ComOv();
         $models = $this->getItemsOvdet();//Obenter los items detalles
        $request = Yii::$app->getRequest();
        
        
        /*
         * Validacion ajax 
         */
        if ($request->isPost && $request->post('ajax') !== null) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                //return \yii\widgets\ActiveForm::validate($model);
                 $data = Yii::$app->request->post('ComOvdet', []);
                    foreach (array_keys($data) as $index) {
                     $models[$index] = new \frontend\modules\com\models\ComOvdet();
                        }
                     //$modelsNuev=$models;
                    // array_push($modelsNuev,$model);
                     Model::loadMultiple($models, Yii::$app->request->post());                   
                    $result = ActiveForm::validateMultiple($models);
                    return $result;                
        }
        
         if ($this->request->isPost) {           
            if ($model->load($this->request->post()) && $model->save()) {
                 $model->refresh();
                if(Model::loadMultiple($models, Yii::$app->request->post())){
                    foreach($models as $modeldetalle){
                        $modeldetalle->ov_id=$model->id;
                        $modeldetalle->save();
                    }
                     return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    var_dump(Model::loadMultiple($models, Yii::$app->request->post()));die();
                }
                
            }else{
                print_r($model->getErrors()); die();
            }
        } else { 
            
        }
       
        return $this->render('create', ['model' => $model,'models' => $models]);
    }
   
     public function actionCreaOvPlus(){ 
        $model = new ComFactura();
        $request = Yii::$app->getRequest();
        /*
         * Colocando valores por default en ComFactura
         */
         $model->setAttributes([
            'codcen'=> Centros::codcen(),
            'codsoc'=> VwSociedades::codsoc(),
            'sunat_tipodoc'=> $model::TYPE_DOC_VOUCHER,
            //'sunat_tipdoccli'=> h::sunat()->graw('s.06.tdociden')->g('DNI'),
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
    
     public function actionCreateStock() {

         $this->layout = "install";
         $model=New Maestrocompo();
         $model->setScenario($model::SCE_PTO_VENTA);
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
                    
                  return ['success'=>1,'id'=>$model->codpro];  
                }else{
                    
                }                
            }
        }else{
           return $this->renderAjax('modal_stock', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    } 
}

<?php

namespace frontend\modules\mat\controllers;

use Yii;
use common\components\SesionDoc;
use frontend\modules\mat\models\MatReq;
use frontend\modules\mat\models\MatVale;
use frontend\modules\mat\models\MatDetvale;
use frontend\modules\mat\models\MatReqSearch;
use frontend\controllers\base\baseController;
use \frontend\modules\mat\models\MatDetreq;
use \frontend\modules\mat\models\VwValeSearch;
use frontend\modules\mat\models\MatVwKardex;
use frontend\modules\mat\models\MatVwKardexSearch;
use frontend\modules\mat\models\MatVwStockSearch;
use frontend\modules\mat\models\MatStockSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
USE yii\db\Query;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * MatController implements the CRUD actions for MatReq model.
 */
class MatController extends baseController
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
     * Lists all MatReq models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \frontend\modules\mat\models\MatVwReqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MatReq model.
     * @param integer $id
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
     * Creates a new MatReq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MatReq();
        
        
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

    /**
     * Updates an existing MatReq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MatReq model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MatReq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MatReq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MatReq::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    public function actionModAgregaMat($id){
    $this->layout = "install";
      $imputado=h::request()->get('imputado');
      $model=$this->findModel($id);
      $modeldet=New \frontend\modules\mat\models\MatDetreq();
      if($imputado=='y')
            $modeldet->setScenario($modeldet::SCE_IMPUTADO);       
            $modeldet->req_id=$id;
            $modeldet->activo=true;
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
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_item_req', [
                        'model' => $modeldet,
                        'id' => $id,
                        'imputado'=>$imputado,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}

     public function actionModEditMat($id){
    $this->layout = "install";
      $modeldet= \frontend\modules\mat\models\MatDetreq::findOne($id);
      $imputado=h::request()->get('imputado');
      if($imputado=='y')
            $modeldet->setScenario($modeldet::SCE_IMPUTADO); 
        $modeldet->setScenario($modeldet::SCE_IMPUTADO);         
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
           return $this->renderAjax('_modal_crea_item_req', [
                        'model' => $modeldet,
                        'id' => $modeldet->id,
                        'imputado'=>$imputado,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}

public function actionAjaxDesactivaItem($id){
    if(h::request()->isAjax){
      h::response()->format = \yii\web\Response::FORMAT_JSON;
       $model= \frontend\modules\mat\models\MatDetreq::findOne($id);
      if(!is_null($model)){
           $model->desactiva();
          return ['success'=>yii::t('app','Se anuló el item')];
      } 
    }
    
   }

   
   
    
     public function actionUpdateVale($id)
    {
        $model = MatVale::findOne($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update_vale', [
            'model' => $model,
        ]);
    }
    
   
     public function actionIndexVale()
    {
        $searchModel = new VwValeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_vale', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    
    
    
    public function actionModAgregaMatVale($id){
    $this->layout = "install";
      $model= MatVale::findOne($id);
      $modeldet=New MatDetvale();
       
       $modeldet->vale_id=$id;
       $modeldet->codal=$model->codal;
           
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
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_item_vale', [
                        'model' => $modeldet,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
   

 public function actionModEditMatVale($id){
    $this->layout = "install";
      $modeldet= \frontend\modules\mat\models\MatDetvale::findOne($id);
                 
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
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_item_vale', [
                        'model' => $modeldet,
                        'id' => $modeldet->id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
     public function actionViewVale($id)
    {
        return $this->render('view_vale', [
            'model' => MatVale::findOne($id),
        ]);
    }
    
    
     public function actionIndexStock()
    {
         
          if ($this->is_editable()){
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            return $this->editField();
           } 
        $searchModel = new MatVwStockSearch();
       //  $searchModel = new MatStockSearch();  
           
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_stock', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function  actionAjaxGuardaIdReqSesion($id){
          if(h::request()->isAjax){
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                if(!is_null($model=MatDetreq::findOne($id))){
                    if($model->activo){
                         $ses=new \common\components\SesionDoc();
                         $ses->inserta(MatDetreq::instance(), $id);
                    }                   
                  }   
                return ['success'=>yii::t('sta.errors','Se agrego el material')];
            }         
         
       }
    
    public function  actionAjaxBorraIdReqSesion($id){
        if(!is_null($model=MatDetreq::findOne($id))){
            $ses=new \common\components\SesionDoc();
            $ses->elimina(MatDetreq::className(), $id);
         }        
    }
    
    /*
     * Esta ation rellena el vale de entrada 
     * o salida con items del detalle requisicion
     */
   public function actionAjaxRellenaIdsFromReq($id){
       $ses=SesionDoc::instance();
       
       foreach($ses->valores(MatDetreq::instance()) as $key=>$iddet){
           if(!is_null($detreq=MatDetreq::findOne($iddet)) && //Si existe el id del detalle de la req
                !MatDetvale::find()->andWhere(['vale_id'=>$id,'detreq_id'=>$iddet])->exists() //Si NO existe en este vale
               ){
                    $model= MatDetvale::instance();
                    $model->setAttributes([
                    'vale_id'=>$id,
                        'item'=>$detreq->item,
                         'cant'=>$detreq->cant,
                        'um'=>$detreq->um,
                         'codart'=>$detreq->codart,
                        ]);
           }
           
       }
   }
  public function actionAjaxAprobarVale($id){
       if(h::request()->isAjax){
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                if(!is_null($model= MatVale::findOne($id))){
                    if($model->isCreado()){
                        $model->Aprobar();
                    }else{
                        return ['error'=>yii::t('base.errors','No tiene el status adecuado')];
                    }                   
                  }   
                return ['success'=>yii::t('base.errors','Se aprobó el vale')];
            }    
  }
  
  public function actionAjaxAnularVale($id){
      
  }
  
  public function actionAjaxShowMaterial(){       
        if (h::request()->isAjax) {
            $val=h::request()->post('valorInput');///'Valor_input' sale del Widget
            $idpet=h::request()->post('idpet');///'Valor_input' sale del Widget
            yii::error(h::request()->post(),__FUNCTION__);
             yii::error(h::request()->post('valorInput'),__FUNCTION__);
            if(strlen($val)>2)
            return $this->renderAjax('listado_material',['parametro'=>$val,'idpet'=>$idpet]);
            
         }     
   }
 public function actionAjaxAddArt($id){       
        if (h::request()->isAjax) {
            //$id=h::request()->get('valorInput');
           // var_dump($val);die();
            $model = \common\models\masters\Maestrocompo::find()->andWhere(['id'=>$id])->one();
             h::response()->format = yii\web\Response::FORMAT_JSON;  
             return [$model->attributes];
            
         }     
   }
   
   public function actionModalCreaActivoColector($id) {
         $this->layout = "install";  
         $modelPadre=\frontend\modules\mat\models\MatActivos::findOne($id);
         if(is_null($modelPadre))
         throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
         $model=new \frontend\modules\mat\models\MatActivoscecos();        
         $model->activo_id=$id;
        
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
                   'modal_activo_colector',
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
    } 
   
   public function actionModalEditaActivoColector($id) {
         $this->layout = "install";         
         $model=\frontend\modules\mat\models\MatActivoscecos::findOne($id);        
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
                   'modal_activo_colector',
                   [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        }
    } 
    
  
  public function actionCreaValeMultiple(){ 
        
        $model = new MatVale();
        $request = Yii::$app->getRequest();       
         $models =[new MatDetvale()];// $this->getItemsOvdet();//Obenter los items detalles
           
        /*
         * Validacion ajax 
         */
        // var_dump($request->isAjax); die();
        if ($request->isPost && $request->post('ajax') !== null) {
            
            
            yii::error('VALIDACION AJAX');
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                 $data = Yii::$app->request->post('MatDetvale', []); 
                 if(count($data)==0){
                        $result[\yii\helpers\Html::getInputId($model,'numero')] = [yii::t('base.errors','No child records have been registered')];
                         return $result;
                 }
                 
                   //yii::error('La data eta aqui');
                   //yii::error($data,__FUNCTION__);
                    foreach (array_keys($data) as $index) {
                     $models[$index] = new \frontend\modules\mat\models\MatDetvale();
                        }
                    Model::loadMultiple($models, Yii::$app->request->post());
                    
                      $model->load($this->request->post());
                      
                    $resultPadre = ActiveForm::validate($model);   
                    $resultDetalle= ActiveForm::validateMultiple($models); 
                    return $resultPadre+$resultDetalle;
                             
        }
        
         if ($this->request->isPost) {  
             // VAR_DUMP($this->request->post(),$model->attributes);
            // DIE();
            if ($model->load($this->request->post()) && $model->save()) {
                 $model->refresh();
                 $data = Yii::$app->request->post('MatDetvale', []);
                    foreach (array_keys($data) as $index) {
                     $models[$index] = new MatDetvale();
                        }
                if(Model::loadMultiple($models, Yii::$app->request->post())){
                      $item=100;
                    foreach($models as $modeldetalle){
                          $modeldetalle->vale_id=$model->id;
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
        return $this->render('create_vale', ['model' => $model,'items' => $models]);
    }
    
     public function actionCreaVale()
    {
        $model = new MatVale();
        //$model->valuesDefault();

       //var_dump($model->attributes);die();
        
        /*$models = [new Item()];
        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->post('ajax') !== null) {
            $data = Yii::$app->request->post('Item', []);
            foreach (array_keys($data) as $index) {
                $models[$index] = new Item();
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);
            return $result;
        }

        if (Model::loadMultiple($models, Yii::$app->request->post())) {
            // your magic
        }
        */
        
       /* VAR_DUMP(Yii::$app->request->post('Detdocbotellas'));
        echo "<br>";
        */
        
        
          //$items=[new Detdocbotellas()];
          //$request = Yii::$app->getRequest();
         if(Yii::$app->request->isPost){
             $arraydetalle=Yii::$app->request->post('MatDetvale');
             $arraycabecera=Yii::$app->request->post('MatVale');
             
             /*Nos aseguramos que los indices se reseteen con array_values
              * ya que cada vez que borramos con ajax en el form quedan 
              * vacancias en los indices y al momento de hacer el loadMultiple
              * no coinciden los indices; algunos modelos no cargan los atributos
              * y arroja false 
              */
             
             //Pero primero guardamos los indices del form antes de resetearlo
             //para despues restablecerlos; esto para enviar los mensajes de error
             // con la accion Form::ValidateMultiple()
             $OldIndices=array_keys($arraydetalle);
             //Ahora si reseteamos los indices para hacerl el loadMultiple
             $arraydetalle=array_values($arraydetalle);
             
            
             
             /*Generamos los items necesarios*/           
              $items = $this->generateItems(MatDetvale::className(),
                      count($arraydetalle),
                     null
                      );
              
              
                           
         if ( h::request()->isAjax &&
                  $model->load($arraycabecera,'')&& 
                 Model::loadMultiple($items, $arraydetalle,'')
                  ) {
                // var_dump( $model->load($arraycabecera,''));
               // VAR_DUMP($model->attributes);DIE();
              //VAR_DUMP($arraycabecera);DIE();
             
             
             /*
              * Propagando el valor del codal en los hijos
              */
             foreach($items as $item){
                 $item->codal=$arraycabecera['codal'];
             }
             
             /*Antes de hacer Form::ValidateMultiple() , reestablecemos los 
              * indices originales, de esta manera nos aseguramos que los
              * mensajes de error salgan cada cual en su sitio
              */
             $items=array_combine($OldIndices,$items);
                h::response()->format = Response::FORMAT_JSON;
                 return array_merge(
                         ActiveForm::validate($model),
                         ActiveForm::validateMultiple($items)
                         );
                
        }
            /* foreach(Yii::$app->request->post('Parametrosdocu') as $index=>$valor){
              $items[]= new \common\models\masters\Parametrosdocu();
          }*/
         // var_dump(Yii::$app->request->post('Documentos'));echo "<br><br>";
         //var_dump(Yii::$app->request->post('Parametrosdocu',[]));
          /*var_dump(Model::loadMultiple($items, Yii::$app->request->post('Detdocbotellas'),''));
          var_dump(Model::validateMultiple($items));
          var_dump($model->load(Yii::$app->request->post('Docbotellas'),''));
          var_dump($model->validate());
          $items[0]->validate();
          VAR_DUMP($items[0]->getErrors());
          
          die();*/
        //var_dump($items);
       /* $arreglo=Yii::$app->request->post('Detdocbotellas');
        $arreglo=array_values($arreglo);
        var_dump($arreglo);
        echo "<br>";
        echo "<br>";
        echo "<br><br>";
        echo " load mulpitple :";
        var_dump(Model::loadMultiple($items, $arreglo,''));
        echo "<br><br>";
       
             
       ECHO "SIN LA LINKEADA <BR>";
         foreach($items as $item){
            print_r($item->attributes);
                        if($item->validate(null)){
                           echo $item->codigo."->".$item->getFirstError()."<br>";
                        }else{
                          echo \yii\helpers\Json::encode($item->getErrors())."->fallo <br><br><br>";
                        }
                           }
        
        ECHO "<br>AHORA CON LA LINKEADA<BR><BR>";
        
         $items=$this->linkeaCampos(18, $items);
        foreach($items as $item){
            echo "El form  ".$item->formName()."<br>";
            print_r($item->attributes);
                        if($item->validate(null)){
                           echo $item->codigo."->".$item->getFirstError()."<br>";
                        }else{
                          echo \yii\helpers\Json::encode($item->getErrors())."->fallo <br><br><br>";
                        }
                           }
        var_dump(Model::validateMultiple($items));DIE();
        
        */
        
        if ($model->load($arraycabecera,'') &&       
        Model::loadMultiple($items, $arraydetalle,'')&&
         $model->validate()   ){
             
           
           
              $model->save();$model->refresh();
               $items=$this->linkeaCampos($model->id, $items);
                     /*
              * Propagando el valor del codal en los hijos
              */
             foreach($items as $item){
                 $item->codal=$arraycabecera['codal'];
             }
               
               
               
              if(Model::validateMultiple($items)){
                 
                  
             
             
                   
                  foreach($items as $item){
                        if($item->save()){ 
                           // yii::error($item->attributes,__FUNCTION__);
                        }else{
                           // yii::error('errores del item',__FUNCTION__);
                            //yii::error($item->getErrors());
                        }
                           }                    
                } else{  
                    
                }               
              }
              return $this->redirect(['update-vale','id'=>$model->id]);
         }
             
        
        
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            print_r($model->attributes
                    );die();
        }*/
         $items=$this->generateItems(MatDetvale::className(),
         4, //cantidad de items por defeto al crear
                 null);
         foreach($items as $index=> $item){           
             $valor=100+$index;
             $item->item= $valor.'';
         }
         /*Aqui colocamos los valores por default*/
         
         //$model->valuesDefault();
        return $this->render('create_vale', [
            'model' => $model,'items'=>$items
        ]);
        
    }
  
    /*
     * Esta funcion rellena los registoes hijos 
     * con el id recien grabado del padre
     * @valorId: Id integer
     * @items: Array de modelos hijos
     */
    private function linkeaCampos($valorId,&$items){
        for($i = 0; $i < count($items); $i++) {
                                $items[$i]->vale_id=$valorId;
           }
       return $items;
        
    }
   
    public function actionAnularVale(){
        $model=New \frontend\modules\mat\models\MatValeFake();
        $model->setScenarioAnulacion();
         if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
             if($id=$model->resolveVale()){
               return $this->redirect(['update-vale', 'id' => $id]);  
             }else{
                 echo "error"; die();
             }
            
        }

        return $this->render('vale_form_fake', [
            'model' => $model,
        ]);
    }
    public function actionTransferirVale(){
        $model=New \frontend\modules\mat\models\MatValeFake();
        $model->setScenarioTransferencia();
         if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
             if($id=$model->resolveVale()){
               return $this->redirect(['update-vale', 'id' => $id]);  
             }else{
                 echo "error"; die();
             }
            
        }

        return $this->render('vale_form_fake', [
            'model' => $model,
        ]);
    }
    
    
      public function actionIndexKardex()
    {
        $searchModel = new MatVwKardexSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_kardex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
   public function actionAjaxShowKardex() {
        if (h::request()->isAjax) {
           
            $id = h::request()->post('expandRowKey');
            //h::response()->format = \yii\web\Response::FORMAT_JSON;
            var_dump($id);die();
            $model= \frontend\modules\mat\models\MatStock::findOne($id);
            return $this->renderPartial("_expand_kardex", ['model' => $model]);
        }
    } 
    
    
}

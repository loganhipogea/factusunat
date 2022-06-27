<?php

namespace frontend\controllers\masters;

use Yii;
use frontend\controllers\base\baseController;
use common\models\masters\Clipro;
use common\models\masters\Direcciones;
use common\models\masters\DireccionesSearch;
use common\models\masters\ContactosSearch;
use common\models\masters\MaestrocliproSearch;
use common\models\masters\ObjetosCliente;
use common\models\masters\ObjetosClienteQuery;
use common\models\masters\ObjetosClienteSearch;
use common\models\masters\CliproSearch;
use common\models\masters\Contactos;
use common\models\masters\Centros;
use common\helpers\h;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\web\view;

/**
 * CliproController implements the CRUD actions for Clipro model.
 */
class CliproController extends baseController {
    /* const EDIT_HAS_EDITABLE='hasEditable';
      const EDIT_ARBITRARY='XXY4';
      const EDIT_EDITABLE_KEY='editableKey';
      const EDIT_EDITABLE_INDEX='editableIndex';
      const EDIT_EDITABLE_ATTRIBUTE='editableAttribute';
     */

    public $nameSpaces = ['common\models\masters'];

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all Clipro models.
     * @return mixed
     */
    public function actionIndex() {
        
     
        
        
        
       /*$fecha= \Carbon\Carbon::createFromFormat('d.m.Y', '22.08.2019', null);
       var_dump($fecha); die();*/
             
      // $this->layout="install";
        
/* echo h::db()->getSchema()->
                getTableSchema('{{%maestrocompo}}')->
                columns['codart']->size; die();

*/

        $searchModel = new CliproSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clipro model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Clipro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        /*
         * comantando el procedimieto para agrgar padre hijo en claiente
         * por medio de cajas de texto 
         */
        /* $model = new Clipro();
          $modelDetails = [];

          $formDetails = Yii::$app->request->post('Direcciones', []);
          foreach ($formDetails as $i => $formDetail) {
          $modelDetail = new Direcciones(['scenario' => Direcciones::SCENARIO_BATCH_UPDATE]);
          $modelDetail->setAttributes($formDetail);
          $modelDetails[] = $modelDetail;
          }

          //handling if the addRow button has been pressed
          if (Yii::$app->request->post('addRow') == 'true') {
          $model->load(Yii::$app->request->post());
          $modelDetails[] = new Direcciones(['scenario' => Direcciones::SCENARIO_BATCH_UPDATE]);
          return $this->render('create', [
          'model' => $model,
          'modelDetails' => $modelDetails
          ]);
          }

          if ($model->load(Yii::$app->request->post())) {
          if (Model::validateMultiple($modelDetails) && $model->validate()) {
          $model->save();
          foreach($modelDetails as $modelDetail) {
          $modelDetail->codpro = $model->codpro;
          $modelDetail->save();
          }
          return $this->redirect(['view', 'codpro' => $model->codpro]);
          }
          }

          return $this->render('create', [
          'model' => $model,
          'modelDetails' => $modelDetails
          ]);

         */

















        $model = new Clipro();
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }
        
        
        
        if ($model->load(h::request()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->codpro]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Clipro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        
        if ($this->is_editable()){
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            return $this->editField();
           } 

        $model = $this->findModel($id);
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }
        
        
        
        if ($model->load(h::request()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->codpro]);
        }
        $searchModel = new DireccionesSearch();
        $dpDirecciones = $searchModel->searchByCodpro($model->codpro); 
        $searchModel = new ObjetosClienteSearch();
        $dpObjetosCliente = $searchModel->searchByCodpro($model->codpro);
        if(!$model->socio){
            $searchModel = new ContactosSearch();
            $dpContactos = $searchModel->searchByCodpro($model->codpro);
             $searchModel = new MaestrocliproSearch();
             $dpMaestroclipro = $searchModel->searchByCodpro($model->codpro);
        
        }else{
            $dpContactos = null; 
            $dpMaestroclipro = NULL;
        }
       
        
        
        return $this->render('update', [
                    'model' => $model,
                    'dpDirecciones' => $dpDirecciones,
                    'dpContactos' => $dpContactos,
                    'dpMaestroclipro' => $dpMaestroclipro,
                    'dpObjetosCliente' =>$dpObjetosCliente  
        ]);
    }

    /**
     * Deletes an existing Clipro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCreatecontact($id) {
        $this->layout = "install";
        $modelclipro = $this->findModel($id);
        $model = new Contactos();
        $model->codpro=$modelclipro->codpro;
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
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('modal_contactos', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        
    }
    public function actionEditacontacto($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $model= Contactos::findOne($id);
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
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('modal_contactos', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        

       
    }
    public function actionCreateaddresses($id) {
        $this->layout = "install";
        $modelclipro = $this->findModel($id);
        $model = new Direcciones();
        $model->codpro=$modelclipro->codpro;
       $datos=[];
         if(h::request()->isPost){   
             //yii::error('Es post');
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
                //yii::error('Hay errores t');
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                //yii::error('va grabando');
                /*print_r(h::request()->post());
               print_r($model->attributes);die();*/
               if(!$model->save()) print_r($model->getErrors()); 
               // yii::error('creoq uer grabo');
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('modal_direcciones', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
       
    }
    
    /**
     * Finds the Clipro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Clipro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Clipro::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionCreatex() {
        $model = new Company();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                if (Yii::$app->request->isAjax) {
                    // JSON response is expected in case of successful save
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => true];
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    private static function xfindKeyArrayInPost() {
        $arr = h::request()->post();
        $valor = null;
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $valor = $key;
                break;
            }
        }
        return $valor;
    }

    public function xeditField() {
        /* if (!(h::request()->post('hasEditable','x5')==='x5')) {
          $este='\common\models\masters\\'.$this->findKeyArrayInPost();
          $model=$este::findOne( h::request()->post('editableKey'));
          // use Yii's response format to encode output as JSON
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $model->{h::request()->post('editableAttribute')}=h::request()->post($this->findKeyArrayInPost())[h::request()->post('editableIndex')][h::request()->post('editableAttribute')];
          if ($model->load($_POST)) {
          if ($model->save()) {
          return  \yii\helpers\Json::encode(['output'=>'OK', 'message'=>'SE EDITO SIN PROBLEMAS']);
          }
          else {
          RETURN  ['output'=>'Error', 'message'=>$model->getFirstError()];
          }}else {
          return ['output'=>'', 'message'=>''];
          }
          }
         */

        $este = '\common\models\masters\\' . $this->findKeyArrayInPost();
        $model = $este::findOne(h::request()->post(static::EDIT_EDITABLE_KEY));
        // use Yii's response format to encode output as JSON
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model->{h::request()->post(static::EDIT_EDITABLE_ATTRIBUTE)} = h::request()->
                        post($this->findKeyArrayInPost())[h::request()->
                        post(static::EDIT_EDITABLE_INDEX)][h::request()->post(static::EDIT_EDITABLE_ATTRIBUTE)];

        if ($model->load($_POST)) {
            if ($model->save()) {
                return \yii\helpers\Json::encode(['output' => 'OK', 'message' => 'SE EDITO SIN PROBLEMAS']);
            } else {
                RETURN ['output' => 'Error', 'message' => $model->getFirstError()];
            }
        } else {
            return ['output' => '', 'message' => ''];
        }
    }

    /* private function is_editable(){
      return (!(h::request()->post(static::EDIT_HAS_EDITABLE,
      static::EDIT_EDITABLE_ATTRIBUTE)
      ===static::EDIT_EDITABLE_ATTRIBUTE));
      } */

    public function actionSoloprueba() {
        //$this->layout = 'install';

        


        if (!is_null(h::request()->get('final'))) {
            $nombremodal = h::request()->get('nombremodal');
            $nombremodal = 'buscarvalor';
       // echo ('<script src="/yii-application/frontend/web/assets/5702785/jquery.js"></script>');
           // echo (' <script src="/yii-application/frontend/web/assets/c20c51c7/js/bootstrap.js"></script>');
 //echo ('<script src="/yii-application/frontend/web/assets/7336756e/js/bootstrap-dialog.js"></script>');
          echo \yii\helpers\Html::script(" $('#buscarvalor').modal('hide');");
            
        }
        
         if (Yii::$app->request->isPost) {
              echo \yii\helpers\Html::script(" $('#buscarvalor').modal('hide');");
         
         }
        
        if (Yii::$app->request->isAjax) {
            $searchModel = new \common\models\masters\CliproSearch();
            $dataProvider = $searchModel->search(h::request()->queryParams);
            return $this->renderAjax('/finder/index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    
    public function actionSolodialog(){
       // $this->layout='install';
         $searchModel = new \common\models\masters\CliproSearch();
            $dataProvider = $searchModel->search(h::request()->queryParams);
            RETURN $this->renderAjax('/finder/index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
    }
    
    public function actionCreateObject($id){       

        $this->layout = "install";
        $modelclipro = $this->findModel($id);
        $model = new ObjetosCliente;
        //echo $model::className();die();
        //$model->save();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          // echo "salieeo"; die();  
            //$model->$modelclipro->codpro;
            //echo \yii\helpers\Html::script("$('#createCompany').modal('hide'); window.parent.$.pjax({container: '#grilla-contactos'})");
            $this->closeModal('buscarvalor', 'grilla-objetos');
        } elseif (Yii::$app->request->isAjax) {
            
            //var_dump($model->attributes,$model->getErrors());die();
            //print_r(Yii::$app->request->post());die();
            return $this->renderAjax('objetos', [
                        'model' => $model,
                        'model' => $model,
                        'modelclipro' => $modelclipro,
                        //'id' => $id,
                            //'vendorsForCombo'=>  $vendorsForCombo,
                            //'aditionalParams'=>$aditionalParams
            ]);
        } else {
           echo "salio"; die();
            return $this->render('objetos', [
                        'model' => $model,
                        'modelclipro' => $modelclipro,
                        //'vendorsForCombo' => $vendorsForCombo,
            ]);
        }

        
    }
    
    
 
  
 public function actionCreaFromApi(){
     
     if(h::request()->isAjax){
    // h::response()->format = yii\web\Response::FORMAT_JSON;   
        //  h::response()->format = \yii\web\Response::FORMAT_JSON;
         $ruc=h::request()->post('valorInput');
         yii::error('El ruc es ');
          yii::error($ruc);
          yii::error('El PARAMETROS es ');
         YII::ERROR(h::gsetting('general', 'DNI_anonimo'));
        
          //yii::error(h::request()->post());
     $compo=New \common\components\MyClientGeneral();
     $validatorRuc=new \yii\validators\RegularExpressionValidator([
         'pattern'=>h::gsetting('general', 'formatoRUC'),
     ]);
     $validatorDni=new \yii\validators\RegularExpressionValidator([
         'pattern'=>h::gsetting('general', 'formatoDNI'),
     ]);
     
    if($validatorRuc->validate($ruc)){
        if(is_null($model=Clipro::findOne(['rucpro'=>$ruc]))){
            $respuesta=$compo->apiRuc($ruc); 
              yii::error( $respuesta,__FUNCTION__);
                if($respuesta ){
                        //if($respuesta['success']){
                            $nuevoClipro=New Clipro();
                            $nuevoClipro->setAttributes([
                                'rucpro'=>$ruc,
                                'despro'=>$respuesta['nombre'],
                             ]);
                            $nuevoClipro->save();
                            $nuevoClipro->refresh();
                            $ubigeo=$respuesta['ubigeo'];
                                
                            $nuevaDireccion=New Direcciones();
                            $nuevaDireccion->setAttributes([
                                'codpro'=>$nuevoClipro->codpro,
                                'direc'=>$respuesta['direccion'],
                                
                                'coddepa'=>'1'.substr($ubigeo,0,2),
                               'codprov'=>'1'.substr($ubigeo,0,2).'1'.substr($ubigeo,2,2),
                               'coddist'=>'1'.substr($ubigeo,0,2).'1'.substr($ubigeo,2,2).'1'.substr($ubigeo,4,2),
                             ]);
                            $nuevaDireccion->save();
                            yii::error($nuevaDireccion->getErrors());
                            return $nuevoClipro->despro;
                        //}else{
                            //return /*['error'=>*/$respuesta['message']/*]*/;
                         //}
            }else{
               return 'Error en la petición API';
            }
        }else{
            return $model->despro;
        }
    }elseif($validatorDni->validate($ruc)){
        if(is_null($model=Clipro::findOne(['rucpro'=>$ruc]))){
           $respuesta=$compo->apiDni($ruc);  
            $nuevoClipro=New Clipro();
                            $nuevoClipro->setAttributes([
                                'rucpro'=>$ruc,
                                'despro'=>$respuesta['nombre'],
                             ]);
                            $nuevoClipro->save();
                            yii::error($nuevoClipro->getErrors());
                            
              return $nuevoClipro->despro;
        }else{
           return $model->despro;  
        }
    }elseif($ruc==h::gsetting('general', 'DNI_anonimo')){
        
        return h::gsetting('general', 'nombre_anonimo');
    }
     
   }
 }
    
    public function actionEditDireccion($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $model= Direcciones::findOne($id);
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
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('modal_direcciones', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        

       
    }
 
public function actionCreateMaterial($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $model= \common\models\masters\Maestroclipro::findOne($id);
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
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('objetos', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        

       
    }
 
   public function actionAjaxCliproToSocio($id){       
        if (h::request()->isAjax) {
            $model =Clipro::findOne($id);
             h::response()->format = yii\web\Response::FORMAT_JSON;            
                 if($model->convierteSocio())
                return ['success' => yii::t('base.responses', 'Se ha convertido en sociedad')];
                return ['error' => yii::t('base.responses', 'Hubo un error: {error}',['error'=>$model->getFirstError()])];
                  }     
   } 
   public function actionAjaxCliproToEmpresa($id){       
        if (h::request()->isAjax) {
            $model =Clipro::findOne($id);
             h::response()->format = yii\web\Response::FORMAT_JSON;            
                 if($model->convierteSocio(false))
                return ['success' => yii::t('base.responses', 'Se ha revertido la sociedad')];
                return ['error' => yii::t('base.responses', 'Hubo un error: {error}',['error'=>$model->getFirstError()])];
                  }     
   }  
  
 public function actionAgregaCentro($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $modelClipro= \common\models\masters\Clipro::findOne($id);
        $model=New Centros();
        $model->codpro=$modelClipro->codpro;
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
           return $this->renderAjax('modal_centros', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        

       
    }  
 public function actionEditaCentro($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $model= \common\models\masters\Centros::findOne($id);
        
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
           return $this->renderAjax('modal_centros', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        

       
    }

 public function actionCreaAlmacen($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $modelCentros= \common\models\masters\Centros::findOne($id);
        $model=New \common\models\masters\Almacenes();
        //$model->codpro=$modelCentros->codpro;
        $model->codcen=$modelCentros->codcen;
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
           return $this->renderAjax('modal_almacenes', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        

       
    }  
  public function actionCreaCuenta($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $modelClipro= \common\models\masters\Clipro::findOne($id);
        $model=New \common\models\masters\Cuentas();
        //$model->codpro=$modelCentros->codpro;
        $model->codpro=$modelClipro->codpro;
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
                  return ['success'=>1,'id'=>$model->codpro];
            }
        }else{
           return $this->renderAjax('modal_cuentas', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    } 
  public function actionEditaCuenta($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "installx";
        $model= \common\models\masters\Cuentas::findOne($id);
        
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
           return $this->renderAjax('modal_cuentas', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
  public function actionApiCambio(){
     //h::cache()->delete(h::PREFIX_CACHE_TIPO_CAMBIO);
     PRINT_R(h::tipoCambio('USD','2022-06-24'));
      /*$nn=New \common\components\MyClientGeneral();
      var_dump($nn->apiCambio());*/
  } 
    
}

<?php

namespace frontend\controllers\masters;

use Yii;
use common\models\masters\Maestrocompo;
use common\models\masters\MaestrocompoSearch;
use common\models\masters\MaestrocompoSol;
use common\models\masters\ConversionesSearch;
use common\models\masters\MaestrocompoSolSearch;
use common\models\masters\Conversiones;
use common\helpers\h;
use frontend\controllers\base\baseController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use common\models\masters\Familia;
use common\models\masters\SubFamilia;
use common\models\masters\SubSubFamilia;
/**
 * MaterialsController implements the CRUD actions for Maestrocompo model.
 */
class MaterialsController extends baseController
{
    
    
     public $nameSpaces = ['common\models\masters'];
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
     * Lists all Maestrocompo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaestrocompoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Maestrocompo model.
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
     * Creates a new Maestrocompo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //\common\helpers\h::settings()->invalidateCache();
      //var_dump(\common\helpers\h::settings()->get('tables','sizecodigomaterial'));die();
        $model = new Maestrocompo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Maestrocompo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
         if ($this->is_editable()){
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            return $this->editField();
           } 
        
        $model = $this->findModel($id);
          
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        
        
         $searchModel = New ConversionesSearch();
       $probConversiones= $searchModel->searchByMaterial($model->codart);

        
        return $this->render('update', [
            'model' => $model,
            'probConversiones'=>$probConversiones
        ]);
    }

    /**
     * Deletes an existing Maestrocompo model.
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
     * Finds the Maestrocompo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Maestrocompo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Maestrocompo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('base.names', 'The requested page does not exist.'));
    }
    
    public function actionCreaconversion($id){
          $this->layout = "install";
        $modelMaterial = Maestrocompo::findOne(['codart'=>$id]);
        $model = new Conversiones();
        $model->codart=$modelMaterial->codart;
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
           return $this->renderAjax('_conversion', [
                        'model' => $model,
                        'codigo'=>$modelMaterial->codart,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
    }
    
    public function actionModalCreaMaterial(){
          $this->layout = "install";
         $model = new Maestrocompo();
        if(h::request()->isPost){  
            
            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
              $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              return ['success'=>2,'msg'=>$datos];  
            }else{
                if(!$model->save()) print_r($model->getErrors()); 
                return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_form_modal', [
                        'model' => $model,
                        'codigo'=>$model->codart,
                        //'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
    }
     public function actionModalEditaMaterial($id){
          $this->layout = "install";
         $model = Maestrocompo::findOne($id);
        if(h::request()->isPost){   
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
              $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              return ['success'=>2,'msg'=>$datos];  
            }else{
                if(!$model->save()) print_r($model->getErrors()); 
                return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_form_modal', [
                        'model' => $model,
                        'codigo'=>$model->codart,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
    }
   
    /*
     * Devuelve las unidades de medida de un material en 
     * particular listas para renderizar en un combo box o o list box
     */
   public function actionAjaxHtmlUms(){
       $req=h::request();       
      if($req->isAjax){     
       // h::response()->format = yii\web\Response::FORMAT_JSON;    
            if($req->isPost){
                $codart=$req->post('valorInput');
            }elseif($req->isGet){
                $codart=$req->get('valorInput'); 
            }
       $model= Maestrocompo::find()->andWhere(['codart'=>$codart])->one();
            if(is_null($model)){
                $datos=[];
                return '';
            }else{
                //[''=>yii::t('base.verbs','--Seleccione un Valor--')]+$datos;
                $datos=[''=>yii::t('base.verbs','--Seleccione un Valor--')]+$model->dataUms(); 
               // yii::error($datos,__FUNCTION__);
               //yii::error(Html::renderSelectOptions($model->codum, $datos),__FUNCTION__);
                return  Html::renderSelectOptions($model->codum, $datos);
                }       
       
            
      }
   } 
    
   public function actionAjaxDescriMat(){
       $req=h::request();       
      if($req->isAjax){     
        h::response()->format = yii\web\Response::FORMAT_JSON;    
            if($req->isPost){
                $codart=$req->post('codart');
            }elseif($req->isGet){
                $codart=$req->get('codart'); 
}
           
       $model= Maestrocompo::find()->andWhere(['codart'=>$codart])->one();
       
            if(is_null($model)){
               
                return ['success'=>'No'];
            }else{
                return ['success'=>$model->descripcion];
                }       
       
            
      }
   } 
   
   
   
    public function actionCreateFamilia()
    {
        //\common\helpers\h::settings()->invalidateCache();
      //var_dump(\common\helpers\h::settings()->get('tables','sizecodigomaterial'));die();
        $model = new Familia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index-familias', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('create_familia', [
            'model' => $model,
        ]);
    }
   
   public function actionEditarFamilia($id)
    {
        //\common\helpers\h::settings()->invalidateCache();
      //var_dump(\common\helpers\h::settings()->get('tables','sizecodigomaterial'));die();
        $model = Familia::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index-familias', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('update_familia', [
            'model' => $model,
        ]);
    }
    
    
     /**
     * Lists all Maestrocompo models.
     * @return mixed
     */
    public function actionIndexFamilias()
    {
        
        $dataProvider = New \yii\data\ActiveDataProvider([
            'query'=>Familia::find(),
        ]);

        return $this->render('index_familias', [
            
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionCreateSubFamilia()
    {
        //\common\helpers\h::settings()->invalidateCache();
      //var_dump(\common\helpers\h::settings()->get('tables','sizecodigomaterial'));die();
        $model = new SubFamilia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index-sub-familias', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('create_subfamilia', [
            'model' => $model,
        ]);
    }
   
   public function actionEditarSubFamilia($id)
    {
        //\common\helpers\h::settings()->invalidateCache();
      //var_dump(\common\helpers\h::settings()->get('tables','sizecodigomaterial'));die();
        $model = SubFamilia::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index-sub-familias', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('update_subfamilia', [
            'model' => $model,
        ]);
    }
    
    public function actionIndexSubFamilias()
    {
        
        $searchModel = new \common\models\masters\SubFamiliaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_subfamilias', [
             'searchModel' =>  $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     
    public function actionCreateSubSubFamilia()
    {
        //\common\helpers\h::settings()->invalidateCache();
      //var_dump(\common\helpers\h::settings()->get('tables','sizecodigomaterial'));die();
        $model = new SubSubFamilia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index-sub-familias', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('create_subsubfamilia', [
            'model' => $model,
        ]);
    }
   
   public function actionEditarSubSubFamilia($id)
    {
        //\common\helpers\h::settings()->invalidateCache();
      //var_dump(\common\helpers\h::settings()->get('tables','sizecodigomaterial'));die();
        $model = SubSubFamilia::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index-sub-familias', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('update_subsubfamilia', [
            'model' => $model,
        ]);
    }
    
    
    
    
    
     /**
     * Lists all Maestrocompo models.
     * @return mixed
     */
    public function actionIndexSubSubFamilias()
    {
        
        $searchModel = new \common\models\masters\SubSubFamiliaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_subsubfamilias', [
             'searchModel' =>  $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionIndexTreeMaterials(){
         
    $datos=Familia::find()->all();
    $ramas=[];
    /*return[
           ['key'=>$key.'_456', 'title'=>'Departamento 1'],
            ['key'=>$key.'_457', 'title'=>'Departamento 2','lazy'=>true],
         ];*/
    foreach($datos as $fila){
        $ramas[]=[
            'icon'=>'fa fa-dropbox',
            'key'=>'_'.$fila->id.'_',
            'title'=>$fila->prefix().$fila->descrifam,/*.
                     \yii\helpers\Html::a(   '<i style="color:#6f9e30;"><span class="fa fa-plus-circle"></span></i>',
                    \yii\helpers\Url::to(['/sigi/edificios/agrega-partida-tree','id'=>$fila->id,'gridName'=>'grilla-cuentas','idModal'=>'buscarvalor']),
                        [
                            'class'=>"botonAbre",
                            'title' => yii::t('sta.labels','Agregar Colector'),
                        ]
                    ),*/
            'lazy'=>true,
            'tooltip'=>'fill-grupos-cargo_'.$fila->id,
        ];
    }
         $clave=h::request()->get('clave','00.00.00');
         
        $searchModel = new MaestrocompoSearch();
        $dataProvider = $searchModel->search_by_grupo($clave,Yii::$app->request->queryParams);
    
    
     
    return $this->render('index_arbol',['arr_arbol'=>$ramas,'searchModel' =>$searchModel,'dataProvider' =>$dataProvider]);
    
    }
    
   public function  actionFillItemsTree(){
    $clave=h::request()->get('clave');
    $ramas=\common\models\masters\SubSubFamilia::items($clave);
    //$ramas=[];
     h::response()->format = \yii\web\Response::FORMAT_JSON;
    return $ramas;
   }
   
   
   public function actionAjaxRenderListado(){
       $prefijo=h::request()->post('prefijo'); 
       return $this->renderPartial('_ajax_listado',['criteria'=>Maestrocompo::staticCriteriaPrefijo($prefijo)]);
   }
   
   
   
   
   public function actionIndexTreeEstructural(){
       
       foreach(\common\models\masters\MaestrocompoSol:: familias() as  $clave=>$valor){
        $ramas[]=[
            'icon'=>'fa fa-dropbox',
            'key'=>'_'.$clave,
            'title'=>$clave.'-'.$valor,/*.
                     \yii\helpers\Html::a(   '<i style="color:#6f9e30;"><span class="fa fa-plus-circle"></span></i>',
                    \yii\helpers\Url::to(['/sigi/edificios/agrega-partida-tree','id'=>$fila->id,'gridName'=>'grilla-cuentas','idModal'=>'buscarvalor']),
                        [
                            'class'=>"botonAbre",
                            'title' => yii::t('sta.labels','Agregar Colector'),
                        ]
                    ),*/
            'lazy'=>true,
            'tooltip'=>'fill-grupos-cargo_'.$clave,
        ];
    }
     
     $searchModel = new MaestrocompoSolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    return $this->render('index_arbol_estructural',[
        'arr_arbol'=>$ramas,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider
        ]);
    
   }
 public function  actionFillItemsTreeEstr(){
    $clave=h::request()->get('key');
    $ramas= \common\models\masters\MaestrocompoSol::generateNodes(substr($clave,1));
    //$ramas=[];
    
     h::response()->format = \yii\web\Response::FORMAT_JSON;
    return $ramas;
   }
   
 
  public function actionModalCreaMaterialSol($id){
          $this->layout = "install";
         $model = new MaestrocompoSol();
         $model->codsubsubfam_=$id;
        if(h::request()->isPost){ 
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
              $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
                
              return ['success'=>2,'msg'=>$datos];  
            }else{
                if(!$model->save()){
                    print_r($model->getErrors()); 
                }else{ 
                return ['success'=>1,'id'=>$model->codart];                  
                }
                
            }
        }else{
           return $this->renderAjax('_form_modal_sol', [
                        'model' => $model,
                        'codigo'=>$model->codart,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
    } 
   
   
   
  public function actionModalEditaMaterialSol($id){
          $this->layout = "install";
         $model =  MaestrocompoSol::find()->where(['codart'=>$id])->one();
         $model->codsubsubfam_=substr($id,0,6);
        if(h::request()->isPost){ 
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
              $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
                
              return ['success'=>2,'msg'=>$datos];  
            }else{
                if(!$model->save()){
                    print_r($model->getErrors()); 
                }else{ 
                return ['success'=>1,'id'=>$model->codart];                  
                }
                
            }
        }else{
           return $this->renderAjax('_form_modal_sol', [
                        'model' => $model,
                        'codigo'=>$model->codart,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
    }
    
    
    public function actionAjaxVerificaCodSol(){
        $req=h::request();       
      if($req->isAjax){     
        h::response()->format = yii\web\Response::FORMAT_JSON;    
            if($req->isPost){
                $codart=$req->post('codart');
            }elseif($req->isGet){
                $codart=$req->get('codart'); 
            }
           
       $model= MaestrocompoSol::find()->andWhere(['codart'=>$codart])->one();
       /*Verificando que si se ha subido o no, puede tratarse de una modificacion */
       
       
            if(is_null($model)){
               
                return ['success'=>['codart'=>null]];
            }else{
                return ['success'=>$model->attributes];
                }       
       
            
      }
    }
   
}

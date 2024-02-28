<?php

namespace frontend\controllers\masters;

use Yii;
use common\models\masters\Turnos;
use common\models\masters\TurnosSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use common\models\masters\Turnosasignaciones;
use common\models\masters\Turnoscambio;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * TurnosController implements the CRUD actions for Turnos model.
 */
class TurnosController extends baseController
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
     * Lists all Turnos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TurnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Turnos model.
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
     * Creates a new Turnos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Turnos();
        
        
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
     * Updates an existing Turnos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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
     * Deletes an existing Turnos model.
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
     * Finds the Turnos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Turnos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Turnos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    public function actionModalEditaDetTurno($id){
          //$this->layout = "install";
          $model= \common\models\masters\Detturnos::findOne($id);
          //var_dump($modelPadre);die();
          //$model= NEW \common\models\masters\Trabajcuadrilla();
         // var_dump($model->detectaIdReq());die();
          /*$model->setAttributes([
              //'cuadrilla_id'=>$modelPadre->id,
              //'codcuadrilla_id'=>$modelPadre->codigo,
             // 'detos_id'=>$id,              
          ]);*/
           $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_detturnos', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
          
      }
    
    public function actionAsignaTurno($id){
       $model= Turnos::findOne($id);
    
        //$searchModel = new \common\models\masters\VwCuadrillasSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$model->id);
       return $this->render('asigna_turnos',[
           'model'=>$model,
            //'dataProvider' => $dataProvider,
             //'searchModel' => $searchModel,
           ]);
    }
    
   /*
    * Asigna un trabajador en un turno mediante la tabla
    * Turnosasiganciones
    */ 
     public function actionModalAsignaTrabajador($id){
          $modelPadre= Turnos::findOne($id);
          $model= Yii::createObject(Turnosasignaciones::className(),[
              'turno_id'=>$modelPadre->id,
              
          ]);
          $model->turno_id=$modelPadre->id;

         //var_dump($model->turno_id); die();
           $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('modal_asigna_trabajador', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
          
      }
      
      
  /*
   * Agrega un permiso
   * 
   */    
    
  public function actionModalAgregaCambio($id){
        $modelPadre= Turnosasignaciones::findOne($id);
        $model=New \common\models\masters\Turnoscambio();
        $model->setAttributes([
              'turnosasignaciones_id'=>$modelPadre->id,
              //'codcuadrilla_id'=>$modelPadre->codigo,
             // 'detos_id'=>$id,              
          ]);
           $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_cambio', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
          
      } 
      
  public function actionModalEditaCambio($id){        
        $model= \common\models\masters\Turnoscambio::findOne($id);
        
           $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_cambio', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
          
      }     
   /*
    * Aprueba o desaprueba un permiso
    */   
    public function actionAjaxApruebaPermiso($id){
         if(h::request()->isAjax){
          $aprobar=(h::request()->get('aprobar')==='1')?true:false;
             h::response()->format = \yii\web\Response::FORMAT_JSON;
                $model= Turnoscambio::findOne($id);
                
               // var_dump($aprobar); die();
       if(!is_null($model)){
         $tx=$model->getDb()->beginTransaction(); 
            $turnoasignado=$model->turnoasignado;
            if($aprobar){
                $turnoasignado->activo=($model->ingreso >0)?true:false;
            }else{
                if(!$model->soyElMasReciente()) return ['error'=>yii::t('app','Ya existe un documento más reciente que este, no puede desaprobar ')];
                 $turnoasignado->activo=($model->ingreso >0)?false:true;
            }
            $exito=$model->setAprobado($aprobar)->save();
            $exito2= $turnoasignado->save();
            if(!($exito && $exito2)){
                 $tx->rollBack();
               if($turnoasignado->hasErrors()){
                   $error=$turnoasignado->getFirstError();
                   return ['error'=>yii::t('app','Error-H '.$error)];
               }
               
              return ['error'=>yii::t('app','Error-H '.$model->getFirstError())];
             
            }else{
                $tx->commit();
              return ['success'=>yii::t('app','Se efectuó  el cambio')];
            }
       } 
     }
    
   }
      
    /*
    * Aprueba o desaprueba un turno
    */   
    public function actionAjaxDesactivaTurno($id){
         if(h::request()->isAjax){
             
             //var_dump(h::request()->post('desactivar')==='1');die();
          $desactivar=(h::request()->post('desactivar')==='1')?true:false;
             h::response()->format = \yii\web\Response::FORMAT_JSON;
                $model= Turnos::findOne($id);
       if(!is_null($model)){
         $tx=$model->getDb()->beginTransaction();             
            if($desactivar){
               if(!$model->isPosibleDesactivar()){
                return ['error'=>yii::t('app','No es posible desactivar')];   
               }
            }else{
                
            }
            $exito=$model->desactiva(!$desactivar)->save();
            
            if(!($exito)){
                 $tx->rollBack();
              return ['error'=>yii::t('app','Error-H '.$model->getFirstError())];
             
            }else{
                $tx->commit();
              return ['success'=>yii::t('app','Se aprobó el cambio')];
                }
            } 
           }
        }
        
        
    /*
     * Muestra el eegistro de un trahajador asignado 
     * como cabecera  y sus detalles 8Cambios, permisos, liecencias
     */ 
        
        
      public function actionAsignado($id){
          
          $model= \common\models\masters\VwTurnosAsignaciones::findOne(['id'=>$id]);
          return $this->render('asignado',['model'=>$model]);
          
      }
        
     public function actionAjaxEliminaPermiso($id){
         if(h::request()->isAjax){
         
             h::response()->format = \yii\web\Response::FORMAT_JSON;
                $model= Turnoscambio::findOne($id);
       if(!is_null($model)){
           if($model->aprobado){
               return ['error'=>yii::t('base.errors','El documento está aprobado')];
           }elseif($model->hasAttachments()){
               return ['error'=>yii::t('base.errors','El documento tiene adjuntos')];
           }else{
               $model->delete();
               return ['success'=>yii::t('base.errors','El documento fué eliminado')];
           }
       } else{
           return ['warning'=>'Cuidado'];
       }
     }
    
   }    
}

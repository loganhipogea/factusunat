<?php

namespace frontend\modules\prd\controllers;

use Yii;
use frontend\modules\prd\models\PrdPlanos;
use frontend\modules\prd\models\PrdPlanosSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\modules\mat\models\MatDespiece;
/**
 * PlanosController implements the CRUD actions for PrdPlanos model.
 */
class PlanosController extends baseController
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
     * Lists all PrdPlanos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrdPlanosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PrdPlanos model.
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
     * Creates a new PrdPlanos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PrdPlanos();
        
        
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
     * Updates an existing PrdPlanos model.
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
     * Deletes an existing PrdPlanos model.
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
     * Finds the PrdPlanos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PrdPlanos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrdPlanos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    
    public function actionModalCreaPlano($id){
           $this->layout = "install";
           $model = new \frontend\modules\prd\models\PrdPlanos();
          
               $nodoPadre = MatDespiece::findOne($id);           
                //$model->activo_id=$nodoPadre->activo_id;
              $model->matdespiece_id=$nodoPadre->id;
               $model->codart=$nodoPadre->codart;
           
           
            //var_dump($model->attributes); die();
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
           return $this->renderAjax('_modal_crea_edita_plano', [
                        'model' => $model,
                        //'codigo'=>$modelMaterial->codart,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
            ]);  
        } 
    } 
    
    
    public function actionModalEditaPlano($id){
           $this->layout = "install";
           $model = PrdPlanos::findOne($id);
          
           
            //var_dump($model->attributes); die();
        if(h::request()->isPost){ 
           // var_dump(h::request()->post()); die();
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
           return $this->renderAjax('_modal_crea_edita_plano', [
                        'model' => $model,
                        //'codigo'=>$modelMaterial->codart,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
            ]);  
        } 
    }
    
    public function actionAjaxAprobarPlano($id){
         if(h::request()->isAjax){
            
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                $model= \frontend\modules\prd\models\PrdPlanosRevisiones::findOne($id);
                  if(is_null($model)){
                      return ['error'=>yii::t('base.errors','No se encontró el registro para este id')];
                  }else{
                      if($model->setFinal()){
                          $tx=$model->getDb()->beginTransaction();
                          $modelPlano=$model->plano;
                           if( $model->save() && $modelPlano->setAprobado()->save()){
                               $tx->commit();
                               return ['success'=>yii::t('base.errors','Se aprobó el diseño para este PT')];
                           }else{
                               
                               return ['error'=>yii::t('base.errors','Se produjo un error en la grabación de los registros')];
                              $tx->rollBack(); 
                           }
                      }else{
                         // $tx->rollBack();
                          return ['error'=>$model->getFirstError()];
                      }
                  }
                   
                
    }
  }


}
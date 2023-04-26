<?php

namespace frontend\controllers\masters;

use Yii;
use common\models\masters\Transacciones;
use common\models\masters\TransaccionesSearch;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * TransaController implements the CRUD actions for Transacciones model.
 */
class TransaController extends baseController
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
     * Lists all Transacciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransaccionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transacciones model.
     * @param string $codtrans Codtrans
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($codtrans)
    {
        return $this->render('view', [
            'model' => $this->findModel($codtrans),
        ]);
    }

    /**
     * Creates a new Transacciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transacciones();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'codtrans' => $model->codtrans]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transacciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $codtrans Codtrans
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($codtrans)
    {
        $model = $this->findModel($codtrans);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'codtrans' => $model->codtrans]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transacciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $codtrans Codtrans
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($codtrans)
    {
        $this->findModel($codtrans)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transacciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $codtrans Codtrans
     * @return Transacciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($codtrans)
    {
        if (($model = Transacciones::findOne($codtrans)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('base.labels', 'The requested page does not exist.'));
    }
    public function actionModalAgregaDocumento($codtrans){       
            $this->layout = "install";
           
        $modelPadre = $this->findModel($codtrans);
        $model = new \common\models\masters\Transadocs();
        $model->setAttributes(['codtrans'=>$modelPadre->codtrans,
            'tipodoc'=>'10','codestado'=>'10'
            ]);
        
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
           return $this->renderAjax('_modal_agrega_documento', [
                        'model' => $model,
                        'codtrans' => $codtrans,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        
        
       
        
    }
     public function actionModalEditaDocumento($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $model= \common\models\masters\Transadocs::findOne($id);
       // $model=New \common\models\masters\Docutrabajadores();
        //$model->codpro=$modelCentros->codpro;
        //$model->codtra=$modelTrabajador->codigotra;
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
                $this->closeModal(
                      h::request()->get('gridName'),
                      h::request()->get('gridName')
                      );
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->codtra];
            }
        }else{
           return $this->renderAjax('_modal_agrega_documento', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
}

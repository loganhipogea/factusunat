<?php

namespace frontend\controllers\masters;

use Yii;
use common\models\masters\Centros;
use common\models\masters\CentrosSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use common\models\masters\Almacenes;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * CentrosController implements the CRUD actions for Centros model.
 */
class CentrosController extends baseController
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
     * Lists all Centros models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CentrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Centros model.
     * @param string $codcen Codcen
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($codcen)
    {
        return $this->render('view', [
            'model' => $this->findModel($codcen),
        ]);
    }

    /**
     * Creates a new Centros model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Centros();
        $model->codpro= \common\models\masters\VwSociedades::codpro();
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'codcen' => $model->codcen]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Centros model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $codcen Codcen
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($codcen)
    {
        $model = $this->findModel($codcen);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'codcen' => $model->codcen]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Centros model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $codcen Codcen
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($codcen)
    {
        $this->findModel($codcen)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Centros model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $codcen Codcen
     * @return Centros the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($codcen)
    {
        if (($model = Centros::findOne($codcen)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('base.names', 'The requested page does not exist.'));
    }
    
    
     public function actionCreaCajaVenta($codcen) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $modelCentros= \common\models\masters\Centros::findOne($codcen);
        $model=New \frontend\modules\com\models\ComCajaventa();
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
           return $this->renderAjax('modal_cajas', [
                        'model' => $model,
                        'id' => $codcen,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        

       
    } 
    
   public function actionUpdateAlmacen($codal){
       $model= Almacenes::findOne($codal);
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update_almacen', [
            'model' => $model,
        ]);
   }
   
   
   
    public function actionModalCreaMaterialAlmacen($codal) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $modelAlmacen= \common\models\masters\Almacenes::findOne($codal);
        $model=New \frontend\modules\mat\models\MatMatAlmacen();
        //$model->codpro=$modelCentros->codpro;
        $model->codal=$modelAlmacen->codal;
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
           return $this->renderAjax('_modal_almacen_material', [
                        'model' => $model,
                        'id' => $codal,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        

       
    } 
    public function actionModalEditaMaterialAlmacen($id) {

        //$vendorsForCombo=ArrayHelper::map(Clipro::find()->all(),'codpro','despro');
        $this->layout = "install";
        $model= \frontend\modules\mat\models\MatMatAlmacen::findOne($id);
       
        //$model->codpro=$modelCentros->codpro;
        
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
           return $this->renderAjax('_modal_almacen_material', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
        

       
    } 
}

<?php

namespace frontend\controllers\masters;

use Yii;
use common\models\masters\Maestrocompo;
use common\models\masters\MaestrocompoSearch;
use common\models\masters\ConversionesSearch;
use common\models\masters\Conversiones;
use common\helpers\h;
use common\controllers\base\baseController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaterialsController implements the CRUD actions for Maestrocompo model.
 */
class MaterialsController extends baseController
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
}

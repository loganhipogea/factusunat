<?php

namespace frontend\modules\com\controllers;
use common\helpers\h;
use frontend\modules\com\models\ComOv;
use frontend\modules\com\ComOvSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
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
   
  private function getItemsOvdet(){
      

        $items =[]; 
           $attributes=[
            'item'=>'100',
             'codsoc'=>'A',
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
}

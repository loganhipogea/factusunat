<?php

namespace frontend\modules\mat\controllers;

use Yii;
use frontend\modules\mat\models\MatActivos;
use frontend\modules\mat\models\MatActivosSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use frontend\modules\mat\models\MatDespiece;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * ActivosController implements the CRUD actions for MatActivos model.
 */
class ActivosController extends baseController
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
     * Lists all MatActivos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MatActivosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MatActivos model.
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
     * Creates a new MatActivos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MatActivos();
        
        
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
     * Updates an existing MatActivos model.
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

        $arr_arbol=[];
        foreach($model->piezasMayores() as $mod){
             $arr_arbol[]=
                        [              
                                'icon'=>'fa fa-dropbox',
                                'key'=>'_'.$mod->id,
                                'title'=>$mod->material->descripcion,
                                'children'=> $mod->childsTreeRecursive() ,   
                            ]
                        ; 
            }
        
        
        return $this->render('update', [
            'model' => $model,
            'arr_arbol'=> $arr_arbol,
        ]);
    }

    /**
     * Deletes an existing MatActivos model.
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
     * Finds the MatActivos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MatActivos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MatActivos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    public function actionModalCreaNodo($id){
           $this->layout = "install";
           $model = new \frontend\modules\mat\models\MatDespiece();
           if($id >0){
               $nodoPadre = MatDespiece::findOne($id);           
                $model->activo_id=$nodoPadre->activo_id;
                $model->parent_id=$nodoPadre->id;
           }else{
                $model->activo_id=-$id;
                $model->parent_id=null;  
           }
           
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
           return $this->renderAjax('_modal_despiece_nodo', [
                        'model' => $model,
                        //'codigo'=>$modelMaterial->codart,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
            ]);  
        } 
    } 
    
    
    public function actionModalEditaNodo($id){
           $this->layout = "install";
           $model = MatDespiece::findOne($id);
          
           
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
           return $this->renderAjax('_modal_despiece_nodo', [
                        'model' => $model,
                        //'codigo'=>$modelMaterial->codart,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
            ]);  
        } 
    }
    
    public function actionEditarParte($id){
        $model = MatDespiece::findOne($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        
        return $this->render('editar_parte', [
            'model' => $model,
           // 'arr_arbol'=> $arr_arbol,
        ]);
        
    }
    
    
}

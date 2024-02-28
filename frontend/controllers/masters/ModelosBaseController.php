<?php

namespace frontend\controllers\masters;

use Yii;
use common\models\masters\Modelosbase;
use common\models\masters\ModelosbaseSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\mat\models\MatDespiece;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * ModelosBaseController implements the CRUD actions for Modelosbase model.
 */
class ModelosBaseController extends baseController
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
     * Lists all Modelosbase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModelosbaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Modelosbase model.
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
     * Creates a new Modelosbase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Modelosbase();
        
        
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
     * Updates an existing Modelosbase model.
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
     * Deletes an existing Modelosbase model.
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
     * Finds the Modelosbase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Modelosbase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Modelosbase::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    
     public function actionModalCreaRaiz($id){
          $this->layout = "install";
        $modelPadre = Modelosbase::findOne($id);
        $model = new \frontend\modules\mat\models\MatDespiece();
        $model->modelobase_id=$id;
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
           return $this->renderAjax('_modal_despiece', [
                        'model' => $model,
                        //'codigo'=>$modelMaterial->codart,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
            ]);  
        } 
    }
    
    public function actionAjaxObtieneIdDespiece(){
       if(h::request()->isAjax){
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                   $model=MatDespiece::find()->orderBy(['id'=>SORT_DESC])->one();
                   $matriz=[];
                   $matriz['success']=$model->attributes;
                   $matriz['success']['descripcion']=$model->material->descripcion;
                    return $matriz;
                }
       }
       
       /*
        * El id del parent
        */
       public function actionModalCreaNodo($id){
           $this->layout = "install";
           $model = new \frontend\modules\mat\models\MatDespiece();
           if($id >0){
               $nodoPadre = MatDespiece::findOne($id);           
                $model->modelobase_id=$nodoPadre->modelobase_id;
                $model->parent_id=$nodoPadre->id;
           }else{
                $model->modelobase_id=-$id;
                $model->parent_id=null;  
           }
           
            //var_dump($nodoPadre->attributes); die();
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
      /*
        * El id del parent
        */
       public function actionModalEditaNodo($id){
           $this->layout = "install";
           $model = MatDespiece::findOne($id);
           
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
}

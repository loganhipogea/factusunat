<?php

namespace frontend\modules\mat\controllers;

use Yii;
use frontend\modules\mat\models\MatPetoferta;
use frontend\modules\mat\models\MatPetofertaSearch;
use common\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use frontend\modules\mat\models\MatDetpetoferta;
use yii\base\Model;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * PetofertaController implements the CRUD actions for MatPetoferta model.
 */
class PetofertaController extends baseController
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
     * Lists all MatPetoferta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MatPetofertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MatPetoferta model.
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
     * Creates a new MatPetoferta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MatPetoferta();
        
        
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
    
    
    
    
  public function actionCreaPetOferta(){ 
        
        $model = new MatPetoferta();
        $request = Yii::$app->getRequest();       
         $models =[new MatDetpetoferta()];// $this->getItemsOvdet();//Obenter los items detalles
           
        /*
         * Validacion ajax 
         */
        // var_dump($request->isAjax); die();
        if ($request->isPost && $request->post('ajax') !== null) {
            yii::error('VALIDACION AJAX');
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                 $data = Yii::$app->request->post('MatDetpetoferta', []);               
                    foreach (array_keys($data) as $index) {
                     $models[$index] = new \frontend\modules\mat\models\MatDetpetoferta();
                        }
                    Model::loadMultiple($models, Yii::$app->request->post());
                      $model->load($this->request->post());
                    $result = ActiveForm::validate($model);                      
                     if(count($result)==0){ //Si el encabezado va bien en todo
                        if(count($data)==0){
                             $result[\yii\helpers\Html::getInputId($model,'nombre_cliente')] = [yii::t('base.errors','No child records have been registered')];
                             return $result;
                         }
                      $result = ActiveForm::validateMultiple($models); 
                        return $result;
                     }else{
                         return $result;  
                     }           
        }
        
         if ($this->request->isPost) {  
             // VAR_DUMP($this->request->post(),$model->attributes);
            // DIE();
            if ($model->load($this->request->post()) && $model->save()) {
                 $model->refresh();
                 $data = Yii::$app->request->post('MatDetpetoferta', []);
                    foreach (array_keys($data) as $index) {
                     $models[$index] = new MatDetpetoferta();
                        }
                if(Model::loadMultiple($models, Yii::$app->request->post())){
                      $item=100;
                    foreach($models as $modeldetalle){
                          $modeldetalle->petoferta_id=$model->id;
                        /*$modeldetalle->setIdChild($model->id)
                                ->setItem($item.'')->
                                setTipoDocSunat($model->sunat_tipodoc)-> //Boleta o factura
                                setTipoTributoIGV() //Tiene IGV
                                ->setTipoAfectacionEsGravada(); //  Es gravada  (Puede ser exonerada, pero tiene que indicarlo el usuario)                   
                       */ if(!$modeldetalle->save()){
                            yii::error($modeldetalle->getErrors(),__FUNCTION__);
                        }
                       $item++;
                    }
                     //$model->refreshValues(); 
                     yii::error('attributos del modelo');
                     yii::error($model->attributes);
                      // $model->preparePdfInvoice();  
                     
                       
                     return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    var_dump(Model::loadMultiple($models, Yii::$app->request->post()));die();
                }                
            }else{
                var_dump($model->attributes);
                print_r($model->getErrors()); die();
            }
        } else { 
            
        }       
        return $this->render('create', ['model' => $model,'items' => $models]);
    }
    
    
    
    /**
     * Updates an existing MatPetoferta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdatePetOferta($id)
    {
        $model = $this->findModel($id);
        $models=$model->matDetpetoferta;
        $request = Yii::$app->getRequest();   
        if ($request->isPost && $request->post('ajax')!== null) {
            $models=[];
             h::response()->format = \yii\web\Response::FORMAT_JSON;
                 $data = Yii::$app->request->post('MatDetpetoferta', []); 
                 $idsModels= array_column($data,'id');
                 $models=$model->getMatDetpetoferta()->andWhere(['in','id',$idsModels])->all();                   
                   
                 
                 /*
                  * Verificando los items que se agregaron
                  */
                    foreach($data as $index=>$dato){
                        if(empty($dato['id'])){
                            $modelTemp=New MatDetpetoferta();
                            $modelTemp->setAttributes($dato);
                            $modelTemp->petoferta_id=$id;
                            $models[]=$modelTemp;                            
                        }
                            
                    }
                 
                 /*
                  * Fin de la verificacion de items agregados
                  */
                    
                    
                  /****************************************
                  * De los items que se borraron hay que eliminarlos
                  ******************************************/
                    MatDetpetoferta::deleteAll(['not in','id',$idsModels]);
                 
                 /************************************ */
                 
                 
                 Model::loadMultiple($models, Yii::$app->request->post());
                      $model->load($this->request->post());
                    $result = ActiveForm::validate($model);                      
                     if(count($result)==0){ //Si el encabezado va bien en todo
                        if(count($data)==0){///si borro todos los items no permitirlo
                             $result[\yii\helpers\Html::getInputId($model,'nombre_cliente')] = [yii::t('base.errors','No child records have been registered')];
                             return $result;
                         }
                        $result = ActiveForm::validateMultiple($models); 
                        return $result;
                     }else{
                         return $result;  
                     }           
        }
        
        if ($this->request->isPost) {  
            $models=[];
             if ($model->load($this->request->post()) && $model->save()) {
                 yii::error('PASANDO EL SAVE ',__FUNCTION__);
                  yii::error('EL POST ',__FUNCTION__);
                  yii::error(Yii::$app->request->post(),__FUNCTION__);
                   $data = Yii::$app->request->post('MatDetpetoferta', []); 
                 $idsModels= array_column($data,'id');
                 $models=$model->getMatDetpetoferta()->andWhere(['in','id',$idsModels])->all();                   
                   
                 
                 /*
                  * Verificando los items que se agregaron
                  */
                    foreach($data as $index=>$dato){
                        if(empty($dato['id'])){
                            $modelTemp=New MatDetpetoferta();
                            $modelTemp->setAttributes($dato);
                            $modelTemp->petoferta_id=$id;
                            $models[]=$modelTemp;                            
                        }
                            
                    }
                 
                 /*
                  * Fin de la verificacion de items agregados
                  */
                    
                    
                  /****************************************
                  * De los items que se borraron hay que eliminarlos
                  ******************************************/
                    MatDetpetoferta::deleteAll(['not in','id',$idsModels]);
                 
                 /************************************ */
                 
                if(Model::loadMultiple($models, Yii::$app->request->post())){
                     yii::error('Funciono el LoadMultilpe ',__FUNCTION__);
                      $item=100;
                    foreach($models as $modeldetalle){
                          //$modeldetalle->petoferta_id=$model->id;
                        yii::error($modeldetalle->attributes);
                       if(!$modeldetalle->save()){
                            yii::error($modeldetalle->getErrors(),__FUNCTION__);
                        }
                       $item++;
                    }
                      yii::error('attributos del modelo');
                     yii::error($model->attributes);
                      return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    var_dump(Model::loadMultiple($models, Yii::$app->request->post()),Yii::$app->request->post(),$models);die();
                }                
            }else{
                var_dump($model->attributes);
                print_r($model->getErrors()); die();
            }
        } else { 
            $models=$model->matDetpetoferta;
            
        }       
        return $this->render('update', ['model' => $model,'items' => $models]);
    }

    /**
     * Deletes an existing MatPetoferta model.
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
     * Finds the MatPetoferta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MatPetoferta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MatPetoferta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

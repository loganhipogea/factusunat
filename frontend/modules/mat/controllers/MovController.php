<?php

namespace frontend\modules\mat\controllers;

use Yii;
use frontend\modules\mat\models\MatNe;
use frontend\modules\mat\models\MatNeSearch;
use frontend\modules\mat\models\MatDetNeQuery;
use frontend\modules\mat\models\MatDetNe;
use frontend\modules\mat\models\MatVwIngresos;
use frontend\modules\mat\models\MatVwIngresosSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
USE yii\base\Model;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * OcController implements the CRUD actions for MatOc model.
 */
class MovController extends baseController
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
     * Lists all MatOc models.
     * @return mixed
     */
    public function actionIndexNe()
    {
         //$this->layout="/install";
        $searchModel = new MatVwIngresosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_ne', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MatOc model.
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
     * Creates a new MatOc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreaNe()
    {
        //$this->layout="install";
        $model = new MatNe();
        //$model->valuesDefault();

       //var_dump($model->attributes);die();
        
        /*$models = [new Item()];
        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->post('ajax') !== null) {
            $data = Yii::$app->request->post('Item', []);
            foreach (array_keys($data) as $index) {
                $models[$index] = new Item();
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);
            return $result;
        }

        if (Model::loadMultiple($models, Yii::$app->request->post())) {
            // your magic
        }
        */
        
       /* VAR_DUMP(Yii::$app->request->post('Detdocbotellas'));
        echo "<br>";
        */
        
        
          //$items=[new Detdocbotellas()];
          //$request = Yii::$app->getRequest();
         if(Yii::$app->request->isPost){
             $arraydetalle=Yii::$app->request->post('MatDetNe');
            // yii::error($arraydetalle,__FUNCTION__);
             $arraycabecera=Yii::$app->request->post('MatNe');
             
             /*Nos aseguramos que los indices se reseteen con array_values
              * ya que cada vez que borramos con ajax en el form quedan 
              * vacancias en los indices y al momento de hacer el loadMultiple
              * no coinciden los indices; algunos modelos no cargan los atributos
              * y arroja false 
              */
             
             //Pero primero guardamos los indices del form antes de resetearlo
             //para despues restablecerlos; esto para enviar los mensajes de error
             // con la accion Form::ValidateMultiple()
             $OldIndices=array_keys($arraydetalle);
             //Ahora si reseteamos los indices para hacerl el loadMultiple
             $arraydetalle=array_values($arraydetalle);
             
            
             
             /*Generamos los items necesarios*/           
              $items = $this->generateItems(MatDetNe::className(),
                      count($arraydetalle),
                     null
                      );
              
              
                           
         if ( h::request()->isAjax &&
                  $model->load($arraycabecera,'')&& 
                 Model::loadMultiple($items, $arraydetalle,'')
                  ) {
                // var_dump( $model->load($arraycabecera,''));
               // VAR_DUMP($model->attributes);DIE();
              //VAR_DUMP($arraycabecera);DIE();
             
             
            
             
             /*Antes de hacer Form::ValidateMultiple() , reestablecemos los 
              * indices originales, de esta manera nos aseguramos que los
              * mensajes de error salgan cada cual en su sitio
              */
             $items=array_combine($OldIndices,$items);
                h::response()->format = Response::FORMAT_JSON;
                 return array_merge(
                         ActiveForm::validate($model),
                         ActiveForm::validateMultiple($items)
                         );
                
        }
            /* foreach(Yii::$app->request->post('Parametrosdocu') as $index=>$valor){
              $items[]= new \common\models\masters\Parametrosdocu();
          }*/
         // var_dump(Yii::$app->request->post('Documentos'));echo "<br><br>";
         //var_dump(Yii::$app->request->post('Parametrosdocu',[]));
          /*var_dump(Model::loadMultiple($items, Yii::$app->request->post('Detdocbotellas'),''));
          var_dump(Model::validateMultiple($items));
          var_dump($model->load(Yii::$app->request->post('Docbotellas'),''));
          var_dump($model->validate());
          $items[0]->validate();
          VAR_DUMP($items[0]->getErrors());
          
          die();*/
        //var_dump($items);
       /* $arreglo=Yii::$app->request->post('Detdocbotellas');
        $arreglo=array_values($arreglo);
        var_dump($arreglo);
        echo "<br>";
        echo "<br>";
        echo "<br><br>";
        echo " load mulpitple :";
        var_dump(Model::loadMultiple($items, $arreglo,''));
        echo "<br><br>";
       
             
       ECHO "SIN LA LINKEADA <BR>";
         foreach($items as $item){
            print_r($item->attributes);
                        if($item->validate(null)){
                           echo $item->codigo."->".$item->getFirstError()."<br>";
                        }else{
                          echo \yii\helpers\Json::encode($item->getErrors())."->fallo <br><br><br>";
                        }
                           }
        
        ECHO "<br>AHORA CON LA LINKEADA<BR><BR>";
        
         $items=$this->linkeaCampos(18, $items);
        foreach($items as $item){
            echo "El form  ".$item->formName()."<br>";
            print_r($item->attributes);
                        if($item->validate(null)){
                           echo $item->codigo."->".$item->getFirstError()."<br>";
                        }else{
                          echo \yii\helpers\Json::encode($item->getErrors())."->fallo <br><br><br>";
                        }
                           }
        var_dump(Model::validateMultiple($items));DIE();
        
        */
        
        if ($model->load($arraycabecera,'') &&       
        Model::loadMultiple($items, $arraydetalle,'')&&
         $model->validate()   ){
             
           
           
              $model->save();$model->refresh();
               $items=$this->linkeaCampos($model->id, $items,'guia_id');
                    
               
               
               
              if(Model::validateMultiple($items)){
                   
                  foreach($items as $item){
                        if($item->save()){ 
                            yii::error($item->attributes,__FUNCTION__);
                        }else{
                           yii::error('errores del item',__FUNCTION__);
                            yii::error($item->getErrors());
                        }
                           }                    
                } else{  
                    
                }               
              }
              return $this->redirect(['view-ne','id'=>$model->id]);
         }
             
        
        
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            print_r($model->attributes
                    );die();
        }*/
         $items=$this->generateItems(MatDetNe::className(),
        5, //cantidad de items por defeto al crear
                 null);
         foreach($items as $index=> $item){           
             $valor=100+$index;
             $item->item= $valor.'';
         }
         /*Aqui colocamos los valores por default*/
            
         //$model->valuesDefault();
        return $this->render('crea_ne', [
            'model' => $model,'items'=>$items
        ]);
        
    }
  
    
     /*
     * Esta funcion rellena los registoes hijos 
     * con el id recien grabado del padre
     * @valorId: Id integer
     * @items: Array de modelos hijos
     */
    private function linkeaCampos($valorId,&$items,$nombrecampo){
        for($i = 0; $i < count($items); $i++) {
                                $items[$i]->{$nombrecampo}=$valorId;
           }
       return $items;
        
    }
    
    
    /**
     * Updates an existing MatOc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEditarNe($id)
    {
        //$this->layout="install";
        $model = MatNe::findOne($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-ne', 'id' => $model->id]);
        }

        return $this->render('update_ne', [
            'model' => $model,
        ]);
    }

    public function actionViewNe($id)
    {
        
        //$this->layout="install";
        $model = MatNe::findOne($id);

       
       

        return $this->render('view_ne', [
            'model' => $model,
        ]);
    }
    
    
    
    /**
     * Deletes an existing MatOc model.
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
     * Finds the MatOc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MatOc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MatOc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    
    
     public function actionModEditDetNe($id){
    $this->layout = "install";
      $modeldet= \frontend\modules\mat\models\MatDetNe::findOne($id);
                 
       $datos=[];
        if(h::request()->isPost){
            
            $modeldet->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($modeldet);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $modeldet->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$modeldet->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_item_ne', [
                        'model' => $modeldet,
                        'id' => $modeldet->id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
    
     public function actionModCreaDetNe($id){
    $this->layout = "install";
      $modeldet= new \frontend\modules\mat\models\MatDetNe();
       $modeldet->guia_id=$id;        
       $datos=[];
        if(h::request()->isPost){
            
            $modeldet->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($modeldet);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $modeldet->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$modeldet->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_item_ne', [
                        'model' => $modeldet,
                        'id' => $modeldet->guia_id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}

public function actionAjaxAnulaDetalleItem($id){       
        if (h::request()->isAjax) {
            //$id=h::request()->get('valorInput');
           // var_dump($val);die();
            $model = MatDetNe::find()->andWhere(['id'=>$id])->one();
            //$exito=;
             h::response()->format = yii\web\Response::FORMAT_JSON; 
             if($model->setInactivo()->save()){
                 return ['success'=>yii::t('base.errors','Se anuló el item correctamente')];
             }else{
                 return ['error'=>yii::t('base.errors',$model->getFirstError())];
             }
             
            
         }     
   }
   
 public function actionMakePdfNe($id){
        $this->layout="reportes";
        $rutaTemporal = \yii::getAlias('@temp');
        $nombre= uniqid().'.pdf';
        $model= MatNe::findOne($id);
        $contenido=$this->render('reporte_ne',['model'=>$model]); 
        /*return Yii::$app->html2pdf
    ->convert($contenido)    
    ->send();*/
        
       // echo $contenido; die();
        $pdf=$this->preparePdf($contenido);
      //  $pdf->WriteHTML($contenido);
        $pdf->Output($rutaTemporal .'/'. $nombre, \Mpdf\Output\Destination::INLINE);
        
    }
    public static function  getPdf(){
               $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
  $mpdf= new \Mpdf\Mpdf();
            $mpdf = new \Mpdf\Mpdf([
                'fontDir' => array_merge($fontDirs,[
                Yii::getAlias('@fonts')
                    ]),
    'fontdata' => $fontData + [
        'cour' => [
            'R' => 'Courier.ttf',
            
        ],
       'helvetica' => [
            'R' => 'Helvetica.ttf',
            'I' => 'VerdanaBOLD.ttf',
        ],
        'verdana' => [
            'R' => 'Verdana.ttf',
            'B' => 'VerdanaBOLD.ttf',
        ],
        
    ],
    'default_font' => 'cour'
]);
//print_r($mpdf->fontdata);die();
          
          //$mpdf=new \Mpdf\Mpdf();
          //echo get_class($mpdf);die();
          /* $pdf->methods=[ 
           'SetHeader'=>[($model->tienecabecera)?$header:''], 
            'SetFooter'=>[($model->tienepie)?'{PAGENO}':''],
        ];*/
           
                  
           $mpdf->simpleTables = false;
            $mpdf->packTableData = true;
           //$mpdf->showImageErrors = true;
           //$mpdf->curlAllowUnsafeSslRequests = true; //Permite imagenes de url externas
         return $mpdf;
    }  
  private function preparePdf($contenidoHtml) {
        //  $contenidoHtml = \Pelago\Emogrifier\CssInlinerCssInliner::fromHtml($contenidoHtml)->inlineCss()->render();
        //->renderBodyContent(); 
        $mpdf = self::getPdf();
        // $mpdf->SetHeader(['{PAGENO}']);
        $mpdf->margin_header = 1;
        $mpdf->margin_footer = 1;
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';

        /*$stylesheet = file_get_contents(\yii::getAlias("@frontend/web/css/bootstrap.min.css")); // external css
        $stylesheet2 = file_get_contents(\yii::getAlias("@frontend/web/css/reporte.css")); // external css
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($stylesheet2,1);*/

        /*$mpdf->DefHTMLHeaderByName(
                'Chapter2Header', $this->render("/citas/reportes/cabecera")
        );*/
        //$mpdf->DefHTMLFooterByName('pie',$this->render("/citas/reportes/footer"));
        //$mpdf->SetHTMLHeaderByName('Chapter2Header');
        // $contenidoHtml = \Pelago\Emogrifier\CssInliner::fromHtml($contenidoHtml)->inlineCss($stylesheet)->render();
        $mpdf->WriteHTML($contenidoHtml);
        return $mpdf;
    }    
   
    
}

<?php

namespace frontend\controllers\masters;
 use console\components\Command;
use Yii;
use common\models\masters\Trabajadores;
use common\models\config\Configuracion;
use common\models\masters\TrabajadoresSearch;
use frontend\controllers\base\baseController;
use common\models\base\modelBase;
use common\helpers\h;
use yii\web\Controller;
use yii\db\Migration;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use DateTime;
use Carbon\Carbon;
/**
 * TrabajadoresController implements the CRUD actions for Trabajadores model.
 */
class TrabajadoresController extends baseController
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
     * Lists all Trabajadores models.
     * @return mixed
     */
    public function actionIndex()
    { 
     /*$rows=\frontend\modules\sta\models\Aluriesgo::find()->from('{{%sta_aluriesgo}} t ')->select([
         'count([[t.codcur]]) as cant',
         'm.codalu','t.codperiodo',
         ])->innerJoin('{{%sta_alu}} m ','[[t.codalu]]=m.codalu')
         ->addSelect(['m.ap','m.am','m.nombres'])->where(['[[t.codfac]]'=>'FIC'])->
        groupBy(['t.codalu','t.codperiodo','m.ap','m.am','m.nombres'])
        ->having(['>','count([[codcur]])',1])->orderBy('count([[codcur]]) DESC')->limit(10)->asArray()->all();
      print_r($rows);die();
     */
     /*select count(t.codcur), t.codalu, t.codperiodo,s.ap,s.am,s.nombres  from 
 7av4v_sta_aluriesgo t ,7av4v_sta_alu s where t.codalu=s.codalu and t.codfac='FIC' group by
   t.codalu, t.codperiodo,s.ap,s.am,s.nombres having 
	count(t.codcur) > 1 order by count(t.codcur) desc LIMIT 10*/
        
        /*$naluFim= \frontend\modules\sta\models\Aluriesgo::studentsInRiskByFacQuery('FIM', '2018II')->count();
     $naluFic= \frontend\modules\sta\models\Aluriesgo::studentsInRiskByFacQuery('FIC', '2018II')->count();
     $naluFip= \frontend\modules\sta\models\Aluriesgo::studentsInRiskByFacQuery('FIP', '2018II')->count();
     VAR_DUMP($naluFim,$naluFic,$naluFip);DIE();*/






//echo date('w');die();
      /* $carboncito = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s','2019-08-23 15:34:12')->endOfDay(
               )->format(
               h::gsetting('timeBD','datetime')
               );
       var_dump(h::gsetting('timeBD','datetime'),$carboncito);die(); */
       
         /*  $model= \frontend\modules\sta\models\Talleres::findOne(36);
           $da=$model->rangesToDates();
           foreach($da as $carbon){
               ECHO $carbon->format('Y-m-d H:i:s')."<br>";
           }
           die();*/
          /* $rangos=$model->rangesArray();
            $CarbonInicio=$model->toCarbon('finicitas');
            $periodo=\Carbon\CarbonPeriod::create(
                $model->swichtDate('finicitas', false),
                $CarbonInicio->addWeek(1)->format('Y-m-d'));
            $da=null;
                   
             foreach($periodo as $CarbonP){ 
                  
                 $hinicio=substr($rangos[$CarbonP->dayOfWeek]['hinicio'],0,2)+0;
                   $hfinal=substr($rangos[$CarbonP->dayOfWeek]['hfin'],0,2)+0;
                $carb1=$CarbonP->hour(9)->copy();
                $carb2=$CarbonP->hour(15)->copy();
                    break; 
             }
           echo   $carb2->format('Y-m-d H:i;s')."<br>";die();
                    
            */
             
       /*  foreach($periodo as $CarbonP){              
              if($rangos[$CarbonP->dayOfWeek]['activo']=='1' &&
                  !$this->isHolyDay($CarbonP)){
                  //$rangos[$CarbonP->dayOfWeek]['hinicio']='08:30'
              //$carbones[]=$CarbonP->hour('08');
                  //$CarbonP->hour(1);
                  yii::error($CarbonP);
                   $hinicio=substr($rangos[$CarbonP->dayOfWeek]['hinicio'],0,2)+0;
                   $hfinal=substr($rangos[$CarbonP->dayOfWeek]['hfin'],0,2)+0;
                   $carbones[]=$CarbonP->hour($hinicio);
                   yii::error($CarbonP);
                   $CarbonP->hour(1);
                    $carbones[]=$CarbonP->hour($hfinal);
                     yii::error($CarbonP);
                  
                 }
              }
          
          
          die();
*/

//echo date('w');die();
       //$carboncito = \Carbon\Carbon::createFromFormat('d/m/Y','15/01/2019');
       //var_dump($carboncito);die();
        
        //$period = \Carbon\CarbonPeriod::create('2018-06-14','2 days', '2018-06-20');
//print_r($period->toArray());die();
// Iterate over the period
/*foreach ($period as $date) {
    echo get_class($date);
    echo $date->format('Y-m-d')."<br>\n";
}*/
//die();
    //var_dump(\Carbon\Carbon::rawCreateFromFormat('H:i:s', '00:00', NULL));die();
        
        //var_dump(\Carbon\Carbon::createFromFormat('H:i','09:23'));die();
        
        //$\model= \frontend\modules\sta\models\Rangos::findOne(15);
       // var_dump($model->toCarbon('hinicio'));die();
       //var_dump(\frontend\modules\sigi\models\SigiUnidades::findOne(2)->getChildsUnits()->count());
       //die();




// Command::execute('migrate/down', ['interactive'=>false]);
        //Command::execute('migrate/up', ['interactive' => false]);
        
        
        //Command::execute('migrate', ['migrationPath'=>'@yii/rbac/migrations', 'interactive' => false]);  
       //Command::execute('migrate', ['migrationPath'=>'@yii2mod/settings/migrations', 'interactive' => false]);  
      //Command::execute('migrate', ['migrationPath'=>'@mdm/admin/migrations', 'interactive' => false]);  
     //Command::execute('migrate', ['migrationPath'=>'@nemmo/attachments/migrations', 'interactive' => false]);  
         
        //Command::execute('migrate-admin', ['interactive' => false]);
                         
                          
                       
                     
       //die();
       
        
        
        
        
        
//echo h::user()->identity->tableName();die();
        /*$limon=new \common\models\Profile;
        echo $limon->persona::className();die();*/
    /*$reg=\frontend\modules\sta\models\Citas::findOne(76);
    $fp=$reg->toCarbon('fechaprog');
   $fi=$reg->toCarbon('finicio');
 $ft=$reg->toCarbon('ftermino');  
 var_dump($fp->format($reg->formatToCarbon($reg::_FDATETIME)));die();*/
        
/*        
 $reg=\frontend\modules\sta\models\Citas::findOne(76);
 $reg2=\frontend\modules\sta\models\Citas::findOne(2);
 $foc=$reg->toCarbon('finicio');
 $ftc=$reg->toCarbon('ftermino');
 $fo=$reg2->toCarbon('finicio');
  $ft=$reg2->toCarbon('ftermino');
 /* 
 $rangeCompare=new \common\helpers\RangeDates([$reg->toCarbon('finicio'),
     $reg->toCarbon('ftermino')]);
 $rangeSearch=new \common\helpers\RangeDates([$reg2->toCarbon('finicio'),
     $reg2->toCarbon('ftermino')]);
 
   
 var_dump($reg->isRangeIntoOtherRange($rangeCompare, $rangeSearch),
         $rangeCompare->getDiff($ftc,$ft),
         ($rangeCompare->tolerance)*$rangeCompare->duration,
         $foc->greaterThan($ft)
         );die();*/
//$fecha= \Carbon\Carbon::createFromFormat('d/m/Y','15/08/2019'); 
//var_dump(\Carbon\Carbon::createFromFormat('d/m/Y','15/08/2019'));         die();
       // var_dump(Trabajadores::find()->where(['codigotra'=>'70w03'])->one());die();
        //echo \common\models\masters\Centros::find()->where(true)->one()->codcen;die();
      // print_r(\common\helpers\ComboHelper::getCboDepartamentos());die();
        //$modelo=new Configuracion();
      //print_r($modelo->rules());die();
        $searchModel = new TrabajadoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
/*if (Yii::$app->request->isAjax){
   return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
}else{*/
   return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
//}
        
    }

    /**
     * Displays a single Trabajadores model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
         $model=$this->findModel($id);
        // var_dump(h::request()->isAjax,$model->load(h::request()->post()));die();
         if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'El registro se ha grabado');
            // Multiple alerts can be set like below
           // Yii::$app->session->setFlash('kv-detail-warning', 'A last warning for completing all data.');
            //Yii::$app->session->setFlash('kv-detail-info', '<b>Note:</b> You can proceed by clicking <a href="#">this link</a>.');
            return $this->redirect(['view', 'id'=>$model->id]);
        } else {
            return $this->render('view', ['model'=>$model]);
        }
        
        
        
        
        
       
    }

    /**
     * Creates a new Trabajadores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Trabajadores();
        
       
       // $chema = new Migration();
        //var_dump($chema->getDb()->getSchema()->getTableSchema($model->tableName(), true));
       //die();
//Yii::$app->formatter->locale = 'es_PE';        
       /*echo get_class( DateTime::createFromFormat('yyyy/mm/dd','2018/11/23'))."<br>";
       echo get_class( DateTime::createFromFormat('Y-m-d','2018-11-28'))."<br>";
        die();
        echo Yii::$app->formatter->asRelativeTime(time()-23242554,time())." <br>";
        echo Yii::$app->formatter->asDuration(time())." <br>";
        echo Yii::$app->formatter->asDate(time(),'php:d-m-Y')." <br>";
        echo Yii::$app->formatter->asDate('23/04/2017','short')." <br>";
        echo Yii::$app->formatter->asDate('23-04-2017','long')." <br>";
        echo Yii::$app->formatter->asDate('23-04-2017','full')." <br>";*/
        
       
       /*echo Yii::$app->formatter->asDate('23-04-2017','php:y-M-d')." <br>";
        echo Yii::$app->formatter->asDate('23-04-2017','php:d-m-Y')." <br>";die();
        */
        
        
        /*$objetofecha=DateTime::createFromFormat(
                                                'Y-m-d',
                                                '2015-02-24'
                                        );
        /* var_dump(
                 $objectofecha
                 ); die();
            */     
                 
                 
        //var_dump(Yii::$app->formatter->asDate($objetofecha,'Y-m-d')); die();
        
        
        
        //$model->cumple='1974-04-28';
        //$model->fecingreso='2012-10-01';
        //$model->prepareTimeFields(true);
       // echo  " cumple ".$model->cumple."<br>";
       // echo  " fec ingreso  ".$model->fecingreso."<br>"; die();
        
        //echo yii::$app->settings->get('tables', 'sizeDnis');die();
        //echo $model->gsetting('tables', 'sizeDnis');
        //$model->gsetting('timeBD', 'date');
        //die();

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }
        
        
        
        if ($model->load(h::request()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Trabajadores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
     
       /* $modito=\frontend\modules\import\models\ImportCargamasivaUser::find(31)->one();
        $modito->setScenario('fechita');
        $modito->fechacarga=date('Y-m-d H:i:s');
        $modito->fechacarga=$modito->swichtDate('fechacarga',true);*/
        //var_dump(Carbon::now());die();
        //var_dump($modito->fechacarga,$modito->save(),$modito->getFirstError());die();
        // var_dump(date('d/m/Y H:i:s'));die();
         if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }
        
        
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           return $this->redirect(['view', 'id' => $model->id]);
        }

        
        
        return $this->render('update', [
          'model'=>$model
        ]);
    }

    /**
     * Deletes an existing Trabajadores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Trabajadores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Trabajadores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trabajadores::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('control.errors', 'The requested page does not exist.'));
    }
}

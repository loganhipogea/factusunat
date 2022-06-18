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
}

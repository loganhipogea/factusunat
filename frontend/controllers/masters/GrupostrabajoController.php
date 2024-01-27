<?php

namespace frontend\controllers\masters;

use Yii;
use common\models\masters\Grupostrabajo;
use common\models\masters\GrupostrabajoSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * GrupostrabajoController implements the CRUD actions for Grupostrabajo model.
 */
class GrupostrabajoController extends baseController
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
     * Lists all Grupostrabajo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GrupostrabajoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Grupostrabajo model.
     * @param string $codgrupo Codgrupo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($codgrupo)
    {
        return $this->render('view', [
            'model' => $this->findModel($codgrupo),
        ]);
    }

    /**
     * Creates a new Grupostrabajo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Grupostrabajo();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'codgrupo' => $model->codgrupo]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Grupostrabajo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $codgrupo Codgrupo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($codgrupo)
    {
        $model = $this->findModel($codgrupo);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'codgrupo' => $model->codgrupo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Grupostrabajo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $codgrupo Codgrupo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($codgrupo)
    {
        $this->findModel($codgrupo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Grupostrabajo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $codgrupo Codgrupo
     * @return Grupostrabajo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($codgrupo)
    {
        if (($model = Grupostrabajo::findOne($codgrupo)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

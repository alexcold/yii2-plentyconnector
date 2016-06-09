<?php

namespace alexcold\plentyconnector\controllers;

use Yii;
use alexcold\plentyconnector\models\SoapSetting;
use alexcold\plentyconnector\models\SoapSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SoapSettingController implements the CRUD actions for SoapSetting model.
 */
class SoapSettingController extends Controller {
    public function behaviors () {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'reset-connection-data' => ['post']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'index', 'view', 'delete', 'reset-connection-data'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'index', 'view', 'delete', 'reset-connection-data'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all SoapSetting models.
     * @return mixed
     */
     
    public function actionIndex () {
        $searchModel = new SoapSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SoapSetting model.
     * @param integer $id
     * @return mixed
     */
     
    public function actionView ($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SoapSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     
    public function actionCreate () {
        $model = new SoapSetting();

        if ($model->load(Yii::$app->request->post())){
            if ($model->enabled == 1) {
                SoapSetting::updateAll(['enabled' => 1], 'enabled = :status', [':status' => 0]);
            }
            
            if ($model->save() && $model->testPlentyCall()) {
                return $this->redirect(['view', 'id' => $model->ID]);
            } else {
                return $this->redirect(['view', 'id' => $model->ID]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SoapSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
     
    public function actionUpdate ($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->enabled == 1) {
                SoapSetting::updateAll(['enabled' => 1], 'enabled = :status', [':status' => 0]);
            }
            
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Resets Soap Connection headers and tokens
     * @param integer $id
     * @return mixed
     */
    
    public function actionResetConnectionData ($id) {
        if (Yii::$app->request->isPost() && $this->findModel($id)->resetSoapHeader()) {
            Yii::$app->session->setFlash('info', Yii::t('app', 'Connection Data Was Reseted'));
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Something went wrong, try rewriting the connection'));
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing SoapSetting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
     
    public function actionDelete ($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SoapSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SoapSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel ($id) {
        if (($model = SoapSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

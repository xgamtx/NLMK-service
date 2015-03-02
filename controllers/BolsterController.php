<?php

namespace app\controllers;

use app\models\PathCreator;
use Yii;
use app\models\Bolster;
use app\models\Search\BolsterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadImage;
use yii\web\UploadedFile;

/**
 * BolsterController implements the CRUD actions for Bolster model.
 */
class BolsterController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Bolster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BolsterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bolster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bolster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bolster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Bolster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionSaveRealId($id) {
        $model = $this->findModel($id);

        $model->load(Yii::$app->request->post());
        $model->save();
        return $this->redirect(['//carriage/view', 'id' => $model->carriage_id]);
    }

    /**
     * Deletes an existing Bolster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bolster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bolster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bolster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSaveImage($id)
    {
        $model = $this->findModel($id);
        $imageModel = new UploadImage();

        if (Yii::$app->request->isPost) {
            $imageModel->file = UploadedFile::getInstance($imageModel, 'file');

            if ($imageModel->file && $imageModel->validate()) {
                $path = 'uploads/' . $model->carriage_id . '/bolster';
                PathCreator::createPath($path);
                $address =  $path . '/' . $model->id . '.' . $imageModel->file->extension;
                if ($imageModel->file->saveAs($address)) {
                    $model->image_src = $address;
                    $model->save();
                }
            }
        }

        return $this->redirect(['//carriage/view', 'id' => $model->carriage_id]);
    }
}

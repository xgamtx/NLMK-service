<?php

namespace app\controllers;

use app\models\LogProvider;
use Yii;
use app\models\WheelSet;
use app\models\WheelSetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadImage;
use yii\web\UploadedFile;
use app\models\PathCreator;

/**
 * WheelSettController implements the CRUD actions for WheelSet model.
 */
class WheelSetController extends Controller
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
     * Lists all WheelSet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WheelSetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WheelSet model.
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
     * Creates a new WheelSet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WheelSet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WheelSet model.
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

    /**
     * Deletes an existing WheelSet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSaveRealId($id) {
        $model = $this->findModel($id);

        $model->load(Yii::$app->request->post());
        if ($model->save()) {
            $message = 'Установлен реальный номер колесной пары №' . $model->id . ' в ' . $model->real_id;
            LogProvider::instance()->setContext($model->carriage_id)->save($message);
        }
        return $this->redirect(['//carriage/view', 'id' => $model->carriage_id]);
    }

    /**
     * Finds the WheelSet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WheelSet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WheelSet::findOne($id)) !== null) {
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
                $path = 'uploads/' . $model->carriage_id . '/wheel-set';
                PathCreator::createPath($path);
                $address =  $path . '/' . $model->id . '.' . $imageModel->file->extension;
                if ($imageModel->file->saveAs($address)) {
                    $model->image_src = $address;
                    if ($model->save()) {
                        $message = 'Загружено изображение для колесной пары №' . $model->id;
                        LogProvider::instance()->setContext($model->carriage_id)->save($message);
                    }
                }
            }
        }

        return $this->redirect(['//carriage/view', 'id' => $model->carriage_id]);
    }
}

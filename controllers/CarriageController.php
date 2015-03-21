<?php

namespace app\controllers;

use app\models\CarriageStatus;
use app\models\LogProvider;
use Yii;
use app\models\Carriage;
use app\models\CarriageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadImage;
use yii\web\UploadedFile;
use app\models\PathCreator;

/**
 * CarriageController implements the CRUD actions for Carriage model.
 */
class CarriageController extends Controller
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
     * Lists all Carriage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CarriageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $statusList = CarriageStatus::getAllStatus();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusList' => $statusList
        ]);
    }

    public function actionSaveWeight($id) {
        $model = $this->findModel($id);

        $model->load(Yii::$app->request->post());
        $model->status = CarriageStatus::WEIGHTED;
        if ($model->save()) {
            $message = 'Вагон №' . $model->id . " взвешен";
            LogProvider::instance()->setContext($model->id)->save($message);
        }

        return $this->redirect(['index']);
    }

    /**
     * Displays a single Carriage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (($model->status == CarriageStatus::WEIGHTED) &&
            $model->allImageDownloaded()) {
            $model->status = CarriageStatus::ADOPTED;
            $model->save();
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Carriage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Carriage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Carriage model.
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
     * Deletes an existing Carriage model.
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
     * Finds the Carriage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Carriage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carriage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSaveImage($id, $propertyName)
    {
        $model = $this->findModel($id);
        $imageModel = new UploadImage();

        if (Yii::$app->request->isPost) {
            $imageModel->file = UploadedFile::getInstance($imageModel, 'file');

            if ($imageModel->file && $imageModel->validate()) {
                $path = 'uploads/' . $model->id . '/common_image';
                PathCreator::createPath($path);
                $address =  $path . '/' . $propertyName . '.' . $imageModel->file->extension;
                if ($imageModel->file->saveAs($address)) {
                    $model->{$propertyName} = $address;
                    if ($model->save()) {
                        $message = 'Загружено изображение для вагона №' . $model->id;
                        LogProvider::instance()->setContext($model->id)->save($message);
                    }
                }
            }
        }

        return $this->redirect(['//carriage/view', 'id' => $model->id]);
    }

    public function actionSetStage() {
        $model = new Carriage\CarriageStageChanger(Yii::$app->request->post());
        $model->changeStage();
        return $this->redirect(['index']);
    }
}

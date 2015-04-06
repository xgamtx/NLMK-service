<?php

namespace app\controllers;

use app\models\CarriageStatus;
use app\models\DateConverter;
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
        return $this->render('view/carriageInfo', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Carriage model.
     * @param integer $id
     * @return mixed
     */
    public function actionInventory($id)
    {
        $model = $this->findModel($id);
        if (($model->status == CarriageStatus::WEIGHTED) &&
            $model->allImageDownloaded()) {
            $model->status = CarriageStatus::ADOPTED;
            $model->save();
        }
        return $this->render('view/inventory', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Carriage model.
     * @param integer $id
     * @return mixed
     */
    public function actionDisassemblingOrder($id)
    {
        $model = $this->findModel($id);
        if (($model->status == CarriageStatus::WEIGHTED) &&
            $model->allImageDownloaded()) {
            $model->status = CarriageStatus::ADOPTED;
            $model->save();
        }
        return $this->render('view/disassemblingOrder', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Carriage model.
     * @param integer $id
     * @return mixed
     */
    public function actionDisassemblingSend($id)
    {
        $model = $this->findModel($id);
        if (($model->status == CarriageStatus::WEIGHTED) &&
            $model->allImageDownloaded()) {
            $model->status = CarriageStatus::ADOPTED;
            $model->save();
        }
        return $this->render('view/disassemblingSend', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Carriage model.
     * @param integer $id
     * @return mixed
     */
    public function actionMh1($id)
    {
        $model = $this->findModel($id);
        if (($model->status == CarriageStatus::WEIGHTED) &&
            $model->allImageDownloaded()) {
            $model->status = CarriageStatus::ADOPTED;
            $model->save();
        }
        return $this->render('view/mh1', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Carriage model.
     * @param integer $id
     * @return mixed
     */
    public function actionInventoryMC($id)
    {
        $model = $this->findModel($id);
        if (($model->status == CarriageStatus::WEIGHTED) &&
            $model->allImageDownloaded()) {
            $model->status = CarriageStatus::ADOPTED;
            $model->save();
        }
        return $this->render('view/inventoryMC', [
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
            /** @var $model Carriage */
            $model->act_date = DateConverter::convertToReadable($model->act_date);
            $model->arrive_date = DateConverter::convertToReadable($model->arrive_date);
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
                    $this->editCarriageStatus($model, $propertyName);
                    if ($model->save()) {
                        $imageType = Carriage::getFieldNameByCode($propertyName);
                        if (empty($imageType)) {
                            $imageType = 'изображение';
                        }
                        $message = 'Загружено ' . $imageType . ' для вагона №' . $model->id;
                        LogProvider::instance()->setContext($model->id)->save($message);
                    }
                }
            }
        }

        return $this->redirect(['//carriage/view', 'id' => $model->id]);
    }

    protected function editCarriageStatus(Carriage $model, $imageType) {
        switch ($imageType) {
            case 'im1':
            case 'im2':
                if (!empty($model->im1) && !empty($model->im2) && ($model->status < CarriageStatus::ADOPTED)) {
                    $model->status = CarriageStatus::ADOPTED;
                }
                break;
            case 'act_image':
                if ($model->status < CarriageStatus::WAIT_WRITE) {
                    $model->status = CarriageStatus::WAIT_WRITE;
                }
                break;
            case 'destroy_letter':
                if ($model->status < CarriageStatus::CONFIRMED) {
                    $model->status = CarriageStatus::CONFIRMED;
                }
                break;
            case 'expulsion_act_image':
                if ($model->status < CarriageStatus::ARCHIVE) {
                    $model->status = CarriageStatus::ARCHIVE;
                }
                break;
            default:
                break;
        }
    }

    public function actionSetStage() {
        $model = new Carriage\CarriageStageChanger(Yii::$app->request->post());
        $model->changeStage();
        return $this->redirect(['index']);
    }

    public function actionSetStatus($id, $new_status) {
        $model = $this->findModel($id);
        if (empty($model)) {
            return $this->redirect(['index']);
        }

        if (!in_array($new_status, array(CarriageStatus::ARRIVED, CarriageStatus::CORRECT))) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if ($model->status < $new_status) {
            $model->status = $new_status;
            $model->save();
        }
        return $this->redirect(['view', 'id' => $model->id]);
    }
}

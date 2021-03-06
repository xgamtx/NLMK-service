<?php

namespace app\controllers;

use app\models\Act\DisassemblingOrder;
use app\models\Act\DisassemblingSend;
use app\models\Act\MCInventory;
use app\models\Act\Mh1;
use app\models\CarriagePhoto;
use app\models\CarriageStatus;
use app\models\DateConverter;
use app\models\LogProvider;
use app\models\UploadCarriagePhoto;
use app\models\Warehouse;
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

    const INVENTORY_M_C = 'inventoryMC';
    const M_H_1 = 'MH1';
    const DISASSEMBLING_ORDER = 'disassemblingOrder';
    const DISASSEMBLING_SEND = 'disassemblingSend';
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
        $dataProvider->pagination->pageSize = 50;
        $statusList = CarriageStatus::getAllStatus();
        $storageList = Warehouse::getWarehouseList();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusList' => $statusList,
            'storageList' => $storageList
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
        $contentFile = '';
        if (!empty($model)) {
            $act = new DisassemblingOrder();
            $act->convert($model);
            $htmlFilePath = Yii::$app->basePath . "/web/act/{$id}/disassemblingOrder.html";
            PathCreator::createPath("act/{$id}");
            $act->save($htmlFilePath, MCInventory::HTML);
            $contentFile = file_get_contents($htmlFilePath);
        }
        return $this->render('view/disassemblingOrder', [
            'model' => $model,
            'content' => $contentFile
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
        $contentFile = '';
        if (!empty($model)) {
            $act = new DisassemblingSend();
            $act->convert($model);
            $htmlFilePath = Yii::$app->basePath . "/web/act/{$id}/disassemblingSend.html";
            PathCreator::createPath("act/{$id}");
            $act->save($htmlFilePath, MCInventory::HTML);
            $contentFile = file_get_contents($htmlFilePath);
        }
        return $this->render('view/disassemblingSend', [
            'model' => $model,
            'content' => $contentFile
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
        $contentFile = '';
        if (!empty($model)) {
            $act = new Mh1();
            $act->convert($model);
            $htmlFilePath = Yii::$app->basePath . "/web/act/{$id}/Mh1.html";
            PathCreator::createPath("act/{$id}");
            $act->save($htmlFilePath, MCInventory::HTML);
            $contentFile = file_get_contents($htmlFilePath);
        }
        return $this->render('view/mh1', [
            'model' => $model,
            'content' => $contentFile
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
        $contentFile = '';
        if (!empty($model)) {
            $act = new MCInventory();
            $act->convert($model);
            $htmlFilePath = Yii::$app->basePath . "/web/act/{$id}/inventoryMC.html";
            PathCreator::createPath("act/{$id}");
            $act->save($htmlFilePath, MCInventory::HTML);
            $contentFile = file_get_contents($htmlFilePath);
        }
        return $this->render('view/inventoryMC', [
            'model' => $model,
            'content' => $contentFile,
        ]);
    }

    public function actionSaveXls($id, $type) {
        $model = $this->findModel($id);
        if (!empty($model)) {
            switch ($type) {
                case self::INVENTORY_M_C:
                    $act = new MCInventory();
                    $xlsFilePath = Yii::$app->basePath . "/web/act/{$id}/inventoryMC.xlsx";
                    $xlsFileName = $id . '.Опись материальной ценности.xlsx';
                    break;
                case self::M_H_1:
                    $act = new Mh1();
                    $xlsFilePath = Yii::$app->basePath . "/web/act/{$id}/MH1.xlsx";
                    $xlsFileName = $id . '.МХ-1.xlsx';
                    break;
                case self::DISASSEMBLING_ORDER:
                    $act = new DisassemblingOrder();
                    $xlsFilePath = Yii::$app->basePath . "/web/act/{$id}/DisassemblingOrder.xlsx";
                    $xlsFileName = $id . '.Акт передачи вагона на демонтаж.xlsx';
                    break;
                case self::DISASSEMBLING_SEND:
                    $act = new DisassemblingSend();
                    $xlsFilePath = Yii::$app->basePath . "/web/act/{$id}/DisassemblingSend.xlsx";
                    $xlsFileName = $id . '.Заявка на демонтаж.xlsx';
                    break;
                default:
                    throw new \Exception("Incorrect act type [{$type}]");

            }
            $act->convert($model);
            $act->save($xlsFilePath, MCInventory::EXCEL);
            header('Content-Disposition: attachment; filename=' . $xlsFileName );
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Length: ' . filesize($xlsFilePath));
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            readfile($xlsFilePath);
        }
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

    public function actionUploadCarriagePhotoList($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $imageModel = new UploadCarriagePhoto();
            $imageModel->file = UploadedFile::getInstances($imageModel, 'file');
            $path = 'uploads/' . $model->id . '/carriage_photo';
            PathCreator::createPath($path);
            /** @var UploadedFile $file */
            $photoList = array();
            foreach ($imageModel->file as $ind => $file) {
                $address = $path . '/' . $ind . '.' . $file->name . '.' . $file->getExtension();
                if ($file->saveAs($address)) {
                    $photo = new CarriagePhoto();
                    $photo->carriage_id = $model->id;
                    $photo->name = $address;
                    $photo->save();
                    $photoList[] = $photo;
                }
            }
            $model->populateRelation(Carriage::CARRIAGE_PHOTO, $photoList);
        }

        return $this->redirect(['//carriage/inventory', 'id' => $model->id]);
    }

    protected function saveFile(UploadedFile $file) {

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

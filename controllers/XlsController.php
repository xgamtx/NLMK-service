<?php

namespace app\controllers;

use app\models\Carriage;
use app\models\FileInfo;
use app\models\XlsFileList;
use Yii;
use app\models\Bolster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\UploadForm;
use app\models\UploadedFile;

/**
 * BolsterController implements the CRUD actions for Bolster model.
 */
class XlsController extends Controller
{

    /**
     * Lists all Bolster models.
     * @return mixed
     */
    public function actionUpload() {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $authorId = rand(0, 30000);
            $model->file = UploadedFile::getInstances($model, 'file');

            //todo проверить успешность сохранения в БД
            if ($model->file && $model->validate()) {
                foreach ($model->file as $file) {
                    $fullName = 'uploads/' . $file->baseName . '.' . $file->extension;
                    /** @var UploadedFile $file */
                    $file->saveAsWithDB($fullName, true, $authorId);
                }
                return $this->redirect('collect?author_id=' . $authorId);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionCollect($author_id) {
        $xlsFileList = new XlsFileList();
        $newCarriageList = $xlsFileList->collectDataFromFileList($author_id);
        $oldCarriageList = Carriage::getCarriageList($newCarriageList->getCarriageIdList());
        return $this->render('collect', [
            'newCarriageList' => $newCarriageList,
            'oldCarriageList' => $oldCarriageList,
            'authorId' => $author_id
        ]);
    }

    public function actionSave() {
        $postRequest = Yii::$app->request->post();
        if (!empty($postRequest)) {
            $xlsFileList = new XlsFileList();
            $xlsFileList->saveCarriageList($postRequest);
        }
        return $this->redirect('/web/carriage/index');
    }

    public function actionClear() {
        $fileInfo = new FileInfo();
        $fileInfo->clear();
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
}

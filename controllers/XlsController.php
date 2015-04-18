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

}
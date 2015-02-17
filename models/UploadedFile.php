<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 18.02.15
 * Time: 0:11
 */

namespace app\models;


class UploadedFile extends \yii\web\UploadedFile {
    public function saveAsWithDB($file, $deleteTempFile = true, $authorId) {
        $res = parent::saveAs($file, $deleteTempFile);
        if ($res) {
            $fileInfo = new FileInfo();
            $fileInfo->author = $authorId;
            $fileInfo->name = $file;
            return $fileInfo->save();
        }
        return false;
    }
}
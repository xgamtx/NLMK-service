<?php
/**
 * Created by PhpStorm.
 * User: Vasiliy
 * Date: 02.03.15
 * Time: 9:21
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadImage extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'mimeTypes' => 'image/jpeg, image/png, image/gif',],
        ];
    }

}
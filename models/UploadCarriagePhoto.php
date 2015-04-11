<?php

namespace app\models;

use yii\base\Model;

class UploadCarriagePhoto extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'maxFiles' => 10, 'mimeTypes' => 'image/jpeg, image/png, image/gif',],
        ];
    }
}
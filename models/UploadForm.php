<?php

namespace app\models;

use yii\base\Model;

class UploadForm extends Model
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
            [['file'], 'file', 'maxFiles' => 200, 'extensions' => 'xls, xlsx'],
        ];
    }
}
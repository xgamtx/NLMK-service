<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "file_info".
 *
 * @property integer $id
 * @property string $name
 * @property integer $author
 * @property string $date_create
 */
class FileInfo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'author'], 'required'],
            [['author'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'author' => 'Author',
            'date_create' => 'Date Create',
        ];
    }
}

<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "carriage_photo_storage".
 *
 * @property integer $id
 * @property string $name
 * @property integer $carriage_id
 *
 * @property Carriage $carriage
 */
class CarriagePhoto extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carriage_photo_storage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'carriage_id'], 'required'],
            [['carriage_id'], 'integer'],
            [['name'], 'string', 'max' => 250]
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
            'carriage_id' => 'Carriage ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarriage()
    {
        return $this->hasOne(Carriage::className(), ['id' => 'carriage_id']);
    }
}

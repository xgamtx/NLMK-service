<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "side_frame".
 *
 * @property integer $id
 * @property int $real_id
 * @property integer $produced_year
 * @property integer $factory
 * @property integer $carriage_id
 *
 * @property Carriage $carriage
 */
class SideFrame extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'side_frame';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'real_id', 'produced_year', 'factory', 'carriage_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'real_id' => 'Реальный ID',
            'produced_year' => 'Год изготовления',
            'factory' => 'Завод изготовления',
            'carriage_id' => 'Номер вагона',
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

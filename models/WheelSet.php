<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "wheelset".
 *
 * @property integer $id
 * @property integer $produced_year
 * @property integer $factory
 * @property integer $right_wheel_width
 * @property integer $left_wheel_width
 * @property integer $real_produced_year
 * @property integer $real_factory
 * @property integer $carriage_id
 *
 * @property Carriage $carriage
 */
class WheelSet extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wheelset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'produced_year', 'factory', 'right_wheel_width', 'left_wheel_width', 'real_produced_year', 'real_factory', 'carriage_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produced_year' => 'Год изготовления',
            'factory' => 'Завод изготовления',
            'right_wheel_width' => 'Толщина правого обода колес',
            'left_wheel_width' => 'Толщина правого обода колес',
            'real_produced_year' => 'Реальный год изготовления',
            'real_factory' => 'Реальный завод изготовления',
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

    public static function getName() {
        return 'Колесная пара';
    }
}

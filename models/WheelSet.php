<?php

namespace app\models;

use app\models\WeightRetriever\WheelSetWeightRetriever;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "wheelset".
 *
 * @property integer $id
 * @property int $real_id
 * @property integer $produced_year
 * @property integer $factory
 * @property integer $right_wheel_width
 * @property integer $left_wheel_width
 * @property float $mass
 * @property integer $carriage_id
 * @property string $image_src
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
            [['id', 'real_id', 'produced_year', 'factory', 'right_wheel_width', 'left_wheel_width', 'carriage_id'], 'integer'],
            [['image_src'], 'string', 'max' => 120],
            [['mass'], 'double']
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
            'right_wheel_width' => 'Толщина правого обода колес',
            'left_wheel_width' => 'Толщина правого обода колес',
            'carriage_id' => 'Номер вагона',
            'mass' => 'Масса',
            'image_src' => "Изображение",
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

    public function beforeSave($insert) {
        $this->mass = $this->getWeight();
        return parent::beforeSave($insert);
    }

    public function getWeight() {
        return WheelSetWeightRetriever::getWeightWheelSet($this);
    }

}

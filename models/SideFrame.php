<?php

namespace app\models;

use app\models\WeightRetriever\SideFrameWeightRetriever;
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
 * @property float $mass
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
            [['id', 'real_id', 'produced_year', 'factory', 'carriage_id'], 'integer'],
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
            'carriage_id' => 'Номер вагона',
            'mass' => 'Масса'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarriage()
    {
        return $this->hasOne(Carriage::className(), ['id' => 'carriage_id']);
    }

    public function beforeSave($insert) {
        $this->mass = $this->getWeight();
        return parent::beforeSave($insert);
    }

    public function getWeight() {
        return SideFrameWeightRetriever::getWeightSideFrame($this);
    }
}

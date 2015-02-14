<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\WeightRetriever\BolsterWeightRetriever;

/**
 * This is the model class for table "bolster".
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
class Bolster extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bolster';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mass'], 'required'],
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
        return BolsterWeightRetriever::getWeightBolster($this);
    }
}

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
 * @property float $mass
 * @property string $image_src
 *
 * @property Carriage $carriage
 * @property CarriagePart $partInfo
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
            [['image_src'], 'string', 'max' => 120],
            [['mass'], 'double'],
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

    public function beforeSave($insert) {
        $this->mass = $this->getWeight();
        return parent::beforeSave($insert);
    }

    public function getWeight() {
        $partInfo = $this->getPartInfo();
        if (!$partInfo) {
            return 0;
        }
        return $partInfo->weight;
    }

    public function getFactoryName() {
        /** @var DictFactory $factory */
        $factory = DictFactory::getFactoryById($this->factory);
        return $factory->short_name;
    }

    public function getFactoryDictId() {
        /** @var DictFactory $factory */
        $factory = DictFactory::getFactoryById($this->factory);
        return $factory->dict_id;
    }

    /**
     * @return CarriagePart
     */
    public function getPartInfo() {
        return CarriagePart::getPartInfo($this->produced_year, CarriagePart::SIDE_FRAME_TYPE);
    }

}

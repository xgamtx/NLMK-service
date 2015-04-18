<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dict_carriage_part".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $part_type
 * @property integer $feature
 * @property double $price
 * @property double $weight
 */
class CarriagePart extends ActiveRecord
{
    const WHEELSET_TYPE = 0;
    const BOLSTER_TYPE = 1;
    const SIDE_FRAME_TYPE = 2;

    /** @var CarriagePart[][] */
    protected static $carriagePart;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dict_carriage_part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['part_type', 'feature'], 'integer'],
            [['price', 'weight'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 200]
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
            'description' => 'Description',
            'part_type' => 'Part Type',
            'feature' => 'Feature',
            'price' => 'Price',
            'weight' => 'Вес',
        ];
    }

    public static function getPartInfo($feature, $type) {
        if (empty(self::$carriagePart)) {
            /** @var CarriagePart[] $carriagePartList */
            $carriagePartList = static::find()->all();
            foreach ($carriagePartList as $carriagePart) {
                self::$carriagePart[$carriagePart->part_type][$carriagePart->feature] = $carriagePart;
            }
        }
        return isset(self::$carriagePart[$type][$feature]) ? self::$carriagePart[$type][$feature] : null;
    }

}

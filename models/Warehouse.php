<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "warehouse".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Carriage[] $carriages
 */
class Warehouse extends ActiveRecord {
    /** @var string[] */
    protected static $warehouseNameList;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [[['name'], 'string', 'max' => 40]];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return ['id' => 'ID', 'name' => 'Name',];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarriages() {
        return $this->hasMany(Carriage::className(), ['warehouse_id' => 'id']);
    }

    public static function getNameById($warehouseId) {
        if (!isset(self::$warehouseNameList[$warehouseId])) {
            /** @var Warehouse $warehouse */
            $warehouse = Warehouse::find($warehouseId)->one();
            self::$warehouseNameList[$warehouseId] = $warehouse->name;
        }

        return self::$warehouseNameList[$warehouseId];
    }

}
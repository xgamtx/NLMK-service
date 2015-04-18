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
        if (empty($warehouseId)) {
            return null;
        }

        if (!isset(self::$warehouseNameList[$warehouseId])) {
            /** @var Warehouse $warehouse */
            $warehouse = Warehouse::find($warehouseId)->where(array('id' => $warehouseId))->one();
            self::$warehouseNameList[$warehouseId] = $warehouse->name;
        }

        return self::$warehouseNameList[$warehouseId];
    }

    public static function getIdByName($warehouseName) {
        $warehouse = Warehouse::find()->where(array('name' => $warehouseName))->one();
        if (empty($warehouse) && $warehouseName) {
            $warehouse = new Warehouse();
            $warehouse->name = $warehouseName;
            $warehouse->save();
        }
        return $warehouse->id;
    }

    public static function getWarehouseList() {
        $warehouseList = Warehouse::find()->all();
        $result = array();
        /** @var Warehouse $warehouse */
        foreach ($warehouseList as $warehouse) {
            $result[$warehouse->id] = $warehouse->name;
        }
        self::$warehouseNameList = $result;
        return array('' => 'Все') + $result;
    }

}
<?php

namespace app\models;

use app\models\DictFactory\FactoryDescriptionProvider;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dict_factory".
 *
 * @property integer $id
 * @property integer $dict_id
 * @property string $short_name
 * @property string $long_name
 */
class DictFactory extends ActiveRecord
{
    /** @var DictFactory[] */
    protected static $cache;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dict_factory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dict_id'], 'integer'],
            [['short_name', 'long_name'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dict_id' => 'Dict ID',
            'short_name' => 'Short Name',
            'long_name' => 'Long Name',
        ];
    }

    public function initFromFile() {
        $fileName = 'uploads/100685.xls';
        $factoryDescriptionProvider = new FactoryDescriptionProvider();
        $factoryList = $factoryDescriptionProvider->getFromFile($fileName);
        foreach ($factoryList as $factory) {
            $factory->save();
        }
    }

    protected static function initCache() {
        /** @var DictFactory[] $cache */
        $cache = DictFactory::find()->all();
        foreach ($cache as $factoryInfo) {
            self::$cache[$factoryInfo->id] = $factoryInfo;
        }

    }

    public static function getIdByDictId($dictId) {
        $model = DictFactory::find()
            ->Where(['dict_id' => $dictId])
            ->one();
        if ($model) {
            /** @var DictFactory $model */
            return $model->id;
        } else {
            $factory = new DictFactory();
            $factory->dict_id = $dictId;
            $factory->save();
            return $factory->id;
        }

    }

    public static function getIdByName($factoryName) {
        $model = DictFactory::find()
            ->where(['LIKE', 'short_name', $factoryName])
            ->orWhere(['LIKE', 'long_name', $factoryName])
            ->one();
        if ($model) {
            /** @var DictFactory $model */
            return $model->id;
        } else {
            $factory = new DictFactory();
            $factory->short_name = $factoryName;
            $factory->long_name = $factoryName;
            $factory->save();
            return $factory->id;
        }
    }

    /**
     * @param int $factoryId
     * @return DictFactory
     */
    public static function getFactoryById($factoryId) {
        if (empty(self::$cache)) {
            self::initCache();
        }
        return self::$cache[$factoryId];
    }
}

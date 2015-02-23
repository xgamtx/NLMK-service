<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "carriage".
 *
 * @property integer $id
 * @property string $carriage_type
 * @property double $brutto_weight
 * @property integer $status
 * @property string $storage
 * @property float $full_weight
 * @property float $wheelset_weight
 * @property float $sideFrame_weight
 * @property float $bolster_weight
 *
 * @property Bolster[] $bolsters
 * @property Comment[] $comments
 * @property SideFrame[] $sideFrames
 * @property WheelSet[] $wheelsets
 * @property Warehouse $warehouse
 */
class Carriage extends ActiveRecord
{

    const WHEELSETS = 'wheelsets';
    const SIDE_FRAMES = 'sideFrames';
    const BOLSTERS = 'bolsters';

    protected $full_weight;
    protected $wheelset_weight;
    protected $sideFrame_weight;
    protected $bolster_weight;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carriage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'status'], 'integer'],
            [['brutto_weight'], 'number'],
            [['carriage_type', 'storage'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'carriage_type' => 'Тип вагона',
            'brutto_weight' => 'Тара',
            'status' => 'Статус',
            'storage' => 'ПЗУ',
            'warehouse' => 'Склад'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBolsters()
    {
        return $this->hasMany(Bolster::className(), ['carriage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['carriage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSideFrames()
    {
        return $this->hasMany(SideFrame::className(), ['carriage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWheelsets()
    {
        return $this->hasMany(WheelSet::className(), ['carriage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse_id']);
    }

    public function getName() {
        return 'Вагон №' . $this->id;
    }

    public function getWheelsetsWeight() {
        if (empty($this->wheelset_weight)) {
            $this->wheelset_weight = 0;
            foreach ($this->wheelsets as $wheelset) {
                $this->wheelset_weight += $wheelset->getWeight();
            }
        }

        return $this->wheelset_weight;
    }

    public function getSideFramesWeight() {
        if (empty($this->sideFrame_weight)) {
            $this->sideFrame_weight = 0;
            foreach ($this->sideFrames as $sideFrame) {
                $this->sideFrame_weight += $sideFrame->getWeight();
            }
        }
        return $this->sideFrame_weight;
    }

    public function getBolstersWeight() {
        if (empty($this->bolster_weight)) {
            $this->bolster_weight = 0;
            foreach ($this->bolsters as $bolster) {
                $this->bolster_weight += $bolster->getWeight();
            }
        }
        return $this->bolster_weight;
    }

    public function getWeight() {
        if (empty($this->full_weight)) {
            $this->full_weight = $this->getBolstersWeight() + $this->getWheelsetsWeight() + $this->getSideFramesWeight();
        }
        return $this->full_weight;
    }

    public function isFullInfoEnabled() {
        $bolsterList = $this->getBolsters()->all();
        return !empty($bolsterList);
    }

    public function isCommonInfoEnabled() {
        return !empty($this->carriage_type);
    }

    public function addRelatedData($type, $dataList) {
        foreach ($dataList as $data) {
            $this->link($type, $data);
        }
    }

    public static function getCarriageList($carriageIdList){
        /** @var self[] $carriageList */
        $carriageList = Carriage::find()->where(array('id' => $carriageIdList))->all();
        $result = array();
        foreach ($carriageList as $carriage) {
            $result[$carriage->id] = $carriage;
        }
        return $result;
    }

}

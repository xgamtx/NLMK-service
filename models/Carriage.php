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
 * @property double $weight_z_d
 * @property double $weight_auto
 * @property integer $status
 * @property string $storage
 * @property float $full_weight
 * @property float $wheelset_weight
 * @property float $sideFrame_weight
 * @property float $bolster_weight
 * @property string $im1
 * @property string $im2
 * @property string $datetime_arrived
 * @property int $act_number
 * @property int $act_number_2
 * @property string $destroy_letter
 * @property string $act_image
 * @property string $expulsion_act_image
 * @property string $act_date
 * @property string $arrive_date
 * @property string $inventory_image
 * @property string $comment
 * @property int $warehouse_id
 * @property float $full_price
 *
 * @property Bolster[] $bolsters
 * @property Comment[] $comments
 * @property SideFrame[] $sideFrames
 * @property WheelSet[] $wheelsets
 * @property CarriagePhoto[] $carriagePhotos
 * @property Log[] $logs
 */
class Carriage extends ActiveRecord
{
    const WHEELSETS = 'wheelsets';
    const SIDE_FRAMES = 'sideFrames';
    const BOLSTERS = 'bolsters';
    const CARRIAGE_PHOTO = 'carriagePhoto';

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
            [['id', 'status', 'storage', 'warehouse_id', 'act_number', 'act_number_2'], 'integer'],
            [['brutto_weight', 'weight_auto', 'weight_z_d', 'full_price'], 'number'],
            [['carriage_type', 'datetime_arrived'], 'string', 'max' => 20],
            [['im1', 'im2', 'comment', 'inventory_image'], 'string', 'max' => 120],
            [['act_image', 'destroy_letter', 'expulsion_act_image'], 'string', 'max' => 150],
            [['act_date', 'arrive_date'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер вагона',
            'carriage_type' => 'Тип вагона',
            'brutto_weight' => 'Тара',
            'status' => 'Статус',
            'storage' => 'ПЗУ',
            'warehouse_id' => 'Склад',
            'im1' => 'Изображение1',
            'im2' => 'Изображение2',
            'datetime_arrived' => 'Время прибытия',
            'weight_auto' => 'Масса тары ЖД весы',
            'weight_z_d' => 'Масса лома автовесы',
            'act_number' => 'Номер акта',
            'act_number_2' => 'Номер акта выполненных работ',
            'act_image' => 'Акт выполненных работ',
            'destroy_letter' => 'Письмо на демонтаж',
            'expulsion_act_image' => 'Акт об исключении из общего вагонного парка',
            'act_date' => 'Дата акта',
            'arrive_date' => 'Дата прибытия',
            'comment' => 'Комментарий',
            'inventory_image' => 'Опись номерных деталей',
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
    public function getCarriagePhotos()
    {
        return $this->hasMany(CarriagePhoto::className(), ['carriage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['carriage_id' => 'id']);
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

    public function getSpringWeight() {
        return 1;
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

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (!empty($this->act_date)) {
                $this->act_date = DateConverter::convertToDb($this->act_date);
            }
            if (!empty($this->arrive_date)) {
                $this->arrive_date = DateConverter::convertToDb($this->arrive_date);
            }
            return true;
        } else {
            return false;
        }
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            foreach ($this->wheelsets as $wheelset) {
                $wheelset->delete();
            }
            foreach ($this->bolsters as $bolster) {
                $bolster->delete();
            }
            foreach ($this->sideFrames as $sideFrame) {
                $sideFrame->delete();
            }
            return true;
        } else {
            return false;
        }
    }

    public function allImageDownloaded() {
        if (empty($this->im1) || empty($this->im2)) {
            return false;
        }
        if ((count($this->bolsters) < 2) ||
            (count($this->sideFrames) < 4) ||
            (count($this->wheelsets) < 4)) {
            return false;
        }
        foreach ($this->bolsters as $bolster) {
            if (empty($bolster->image_src)) {
                return false;
            }
        }

        foreach ($this->wheelsets as $wheelSet) {
            if (empty($wheelSet->image_src)) {
                return false;
            }
        }

        foreach ($this->sideFrames as $sideFrame) {
            if (empty($sideFrame->image_src)) {
                return false;
            }
        }

        return true;
    }

    public static function getFieldNameByCode($attributeCode) {
        $carriage = new Carriage();
        $attributes = $carriage->attributeLabels();
        if (isset($attributes[$attributeCode])) {
            return $attributes[$attributeCode];
        }

        return null;
    }

    public function changeStage($stageId) {
        if (CarriageStatus::isAvailableForChangeToStage($this->status, $stageId)) {
            $message = "Изменен статус с '" . CarriageStatus::getLabelByStatusId($this->status) .
                "' на  '" . CarriageStatus::getLabelByStatusId($stageId) . "'";
            LogProvider::instance()->setContext($this->id)->save($message);
            if ($stageId == CarriageStatus::ARRIVED) {
                $this->datetime_arrived = date('Y-m-d H:i:s');
            }
            $this->status = $stageId;
            $this->save();
            return true;
        }

        return false;
    }

    public function getCalculateWasteWeight() {
        $fullWeight = min($this->brutto_weight, $this->weight_z_d);
        return $fullWeight - $this->weight_auto - $this->getSpringWeight();
    }
}

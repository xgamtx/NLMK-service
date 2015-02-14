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
 *
 * @property Bolster[] $bolsters
 * @property Comment[] $comments
 * @property SideFrame[] $sideFrames
 * @property Wheelset[] $wheelsets
 */
class Carriage extends ActiveRecord
{
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
            [['carriage_type'], 'string', 'max' => 20]
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
        return $this->hasMany(Wheelset::className(), ['carriage_id' => 'id']);
    }
}

<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "side_frame".
 *
 * @property integer $id
 * @property integer $produced_year
 * @property integer $factory
 * @property integer $real_produced_year
 * @property integer $real_factory
 * @property integer $carriage_id
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
            [['id', 'produced_year', 'factory', 'real_produced_year', 'real_factory', 'carriage_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produced_year' => 'Produced Year',
            'factory' => 'Factory',
            'real_produced_year' => 'Real Produced Year',
            'real_factory' => 'Real Factory',
            'carriage_id' => 'Carriage ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarriage()
    {
        return $this->hasOne(Carriage::className(), ['id' => 'carriage_id']);
    }
}

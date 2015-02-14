<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WheelSet;

/**
 * WheelSetSearch represents the model behind the search form about `app\models\WheelSet`.
 */
class WheelSetSearch extends WheelSet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'produced_year', 'factory', 'right_wheel_width', 'left_wheel_width', 'real_produced_year', 'real_factory', 'carriage_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WheelSet::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'produced_year' => $this->produced_year,
            'factory' => $this->factory,
            'right_wheel_width' => $this->right_wheel_width,
            'left_wheel_width' => $this->left_wheel_width,
            'real_produced_year' => $this->real_produced_year,
            'real_factory' => $this->real_factory,
            'carriage_id' => $this->carriage_id,
        ]);

        return $dataProvider;
    }
}

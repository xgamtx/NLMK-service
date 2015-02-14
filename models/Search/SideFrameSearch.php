<?php

namespace app\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SideFrame;

/**
 * SideFrameSearch represents the model behind the search form about `app\models\SideFrame`.
 */
class SideFrameSearch extends SideFrame
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'produced_year', 'factory', 'carriage_id', 'real_id'], 'integer'],
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
        $query = SideFrame::find();

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
            'carriage_id' => $this->carriage_id,
            'real_id' => $this->real_id,
        ]);

        return $dataProvider;
    }
}

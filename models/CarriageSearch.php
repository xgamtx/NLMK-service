<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CarriageSearch represents the model behind the search form about `app\models\Carriage`.
 */
class CarriageSearch extends Carriage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['carriage_type', 'storage'], 'safe'],
            [['brutto_weight'], 'number'],
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
        $query = Carriage::find();
        $subQuery = WheelSet::find()
            ->select('carriage_id, SUM(mass) as wheelset_mass')
            ->groupBy('carriage_id');
        $query->leftJoin([
            'wheelset' => $subQuery], 'wheelset.carriage_id = id');

        $subQuery = Bolster::find()
            ->select('carriage_id, SUM(mass) as bolster_mass')
            ->groupBy('carriage_id');
        $query->leftJoin([
            'bolster' => $subQuery], 'bolster.carriage_id = id');

        $subQuery = SideFrame::find()
            ->select('carriage_id, SUM(mass) as side_frame_mass')
            ->groupBy('carriage_id');
        $query->leftJoin([
            'side_frame' => $subQuery], 'side_frame.carriage_id = id');
        $query->select('*, (wheelset_mass + side_frame_mass + bolster_mass) as netto_mass, (brutto_weight - (wheelset_mass + side_frame_mass + bolster_mass)) as scrap_metal');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes'=>[
                'id',
                'carriage_type',
                'storage',
                'brutto_weight',
                'netto_mass'=>[
                    'asc'=>['netto_mass'=>SORT_ASC],
                    'desc'=>['netto_mass'=>SORT_DESC],
                    'label'=>'Order Name'
                ],
                'scrap_metal'=>[
                    'asc'=>['scrap_metal'=>SORT_ASC],
                    'desc'=>['scrap_metal'=>SORT_DESC],
                    'label'=>'Order Name'
                ],
                'status'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'brutto_weight' => $this->brutto_weight,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'carriage_type', $this->carriage_type]);
        $query->andFilterWhere(['like', 'storage', $this->storage]);

        return $dataProvider;
    }
}

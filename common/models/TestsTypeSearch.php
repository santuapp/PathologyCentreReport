<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TestsType;

/**
 * TestsTypeSearch represents the model behind the search form about `common\models\TestsType`.
 */
class TestsTypeSearch extends TestsType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'reference_interval', 'specimen_type', 'testing_frequency', 'comments'], 'safe'],
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
        $query = TestsType::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'reference_interval', $this->reference_interval])
            ->andFilterWhere(['like', 'specimen_type', $this->specimen_type])
            ->andFilterWhere(['like', 'testing_frequency', $this->testing_frequency])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['is_deleted' => 0]);

        return $dataProvider;
    }
}

<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PatientTests;

/**
 * PatientTestsSearch represents the model behind the search form about `common\models\PatientTests`.
 */
class PatientTestsSearch extends PatientTests
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'patient_report_fk_id', 'tests_type_fk_id', 'is_deleted', 'created_by', 'modified_by'], 'integer'],
            [['test_result', 'created_date', 'modified_date'], 'safe'],
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
        $query = PatientTests::find();

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
            'patient_report_fk_id' => $this->patient_report_fk_id,
            'tests_type_fk_id' => $this->tests_type_fk_id,
            'is_deleted' => $this->is_deleted,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'modified_by' => $this->modified_by,
            'modified_date' => $this->modified_date,
        ]);

        $query->andFilterWhere(['like', 'test_result', $this->test_result]);

        return $dataProvider;
    }
}

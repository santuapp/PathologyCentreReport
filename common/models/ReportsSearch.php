<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reports;

/**
 * ReportsSearch represents the model behind the search form about `common\models\Reports`.
 */
class ReportsSearch extends Reports
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'patient_fk_id', 'status', 'is_deleted', 'created_by', 'modified_by'], 'integer'],
            [['exam', 'sample_no', 'referred_doctor', 'doctor_specialization', 'prescription_image', 'prescrption_text', 'summary', 'created_date', 'modified_date'], 'safe'],
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
        $query = Reports::find();

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
            'patient_fk_id' => $this->patient_fk_id,
            'status' => $this->status,
            'is_deleted' => 0,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'modified_by' => $this->modified_by,
            'modified_date' => $this->modified_date,
        ]);

        $query->andFilterWhere(['like', 'exam', $this->exam])
            ->andFilterWhere(['like', 'referred_doctor', $this->referred_doctor])
            ->andFilterWhere(['like', 'doctor_specialization', $this->doctor_specialization])
            ->andFilterWhere(['like', 'prescription_image', $this->prescription_image])
            ->andFilterWhere(['like', 'prescrption_text', $this->prescrption_text])
            ->andFilterWhere(['like', 'summary', $this->summary]);

        return $dataProvider;
    }
}

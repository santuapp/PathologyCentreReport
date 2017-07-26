<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Patient;

/**
 * PatientSearch represents the model behind the search form about `common\models\Patient`.
 */
class PatientSearch extends Patient
{
    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_fk_id', 'created_by', 'modified_by'], 'integer'],
            [['pass_code', 'gender', 'height', 'blood_group', 'address', 'created_date', 'modified_date', 'dob', 'name'], 'safe'],
            [['weight'], 'number'],
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
        $query = Patient::find();
        $query->joinWith(['user']);

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
            //'id' => $this->id,
            //'user_fk_id' => $this->user_fk_id,
            'dob' => $this->dob,
            'weight' => $this->weight,
            'patient_details.created_by' => $this->created_by,
            'patient_details.created_date' => $this->created_date,
            'patient_details.modified_by' => $this->modified_by,
            'patient_details.modified_date' => $this->modified_date,
        ]);

        if(isset(Yii::$app->user->identity->user_type) && Yii::$app->user->identity->user_type == '2') {
            // grid filtering conditions
            $query->andFilterWhere([
                'patient_details.created_by' => Yii::$app->user->identity->id,
            ]);
        }

        $query->andFilterWhere(['like', 'pass_code', $this->pass_code])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'height', $this->height])
            ->andFilterWhere(['like', 'blood_group', $this->blood_group])
            ->andFilterWhere(['like', 'address', $this->address]);

        if(isset($this->name) && !empty($this->name)){
            $query->andFilterWhere(['LIKE', 'user.name', $this->name])->andWhere(['user.is_deleted' => 0]);
        }
        $query->andFilterWhere(['user.is_deleted' => 0]);

        return $dataProvider;
    }
}

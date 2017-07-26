<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "patient_tests".
 *
 * @property integer $id
 * @property integer $patient_report_fk_id
 * @property integer $tests_type_fk_id
 * @property string $test_result
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TestsType $testsTypeFk
 * @property PatientReports $patientReportFk
 */
class PatientTests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_tests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patient_report_fk_id', 'tests_type_fk_id', 'test_result'], 'required'],
            [['patient_report_fk_id', 'tests_type_fk_id', 'is_deleted', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['test_result'], 'string', 'max' => 255],
            [['tests_type_fk_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestsType::className(), 'targetAttribute' => ['tests_type_fk_id' => 'id']],
            [['patient_report_fk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reports::className(), 'targetAttribute' => ['patient_report_fk_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_date', 'modified_date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['modified_date'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return before save rules for model attributes.
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_by = isset(Yii::$app->user->identity->id)?Yii::$app->user->identity->id:0;
        } else {
            $this->modified_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patient_report_fk_id' => 'Patient Report',
            'tests_type_fk_id' => 'Tests',
            'test_result' => 'Test Result',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestsType()
    {
        return $this->hasOne(TestsType::className(), ['id' => 'tests_type_fk_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatientReport()
    {
        return $this->hasOne(PatientReports::className(), ['id' => 'patient_report_fk_id']);
    }

    public function createPatientTests()
    {
        if(!$this->validate()) {
            return null;
        }

        $model = new PatientTests();
        $model->patient_report_fk_id = $this->patient_report_fk_id;
        $model->tests_type_fk_id = $this->tests_type_fk_id;
        $model->test_result = $this->test_result;

        return $model->save() ? $model : null;
    }
}

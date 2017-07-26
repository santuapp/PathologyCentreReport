<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "patient_reports".
 *
 * @property integer $id
 * @property integer $patient_fk_id
 * @property string $exam
 * @property string $referred_doctor
 * @property string $doctor_specialization
 * @property string $prescription_image
 * @property string $prescrption_text
 * @property string $summary
 * @property integer $status
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property PatientDetails $patientFk
 * @property PatientTests[] $patientTests
 */
class Reports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patient_fk_id', 'sample_no', 'exam', 'referred_doctor'], 'required'],
            [['patient_fk_id', 'status', 'is_deleted', 'created_by', 'modified_by'], 'integer'],
            [['prescrption_text', 'summary'], 'string'],
            [['created_date', 'modified_date'], 'safe'],
            [['exam', 'sample_no', 'referred_doctor', 'doctor_specialization', 'prescription_image'], 'string', 'max' => 255],
            [['patient_fk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Patient::className(), 'targetAttribute' => ['patient_fk_id' => 'id']],
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
            $this->created_by = isset(Yii::$app->user->identity->id)?Yii::$app->user->identity->id:Yii::$app->params['user.userTypeSystem'];
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
            'patient_fk_id' => 'Patient',
            'exam' => 'Exam',
            'referred_doctor' => 'Referred Doctor',
            'sample_no' => 'Sample Number',
            'doctor_specialization' => 'Doctor Specialization',
            'prescription_image' => 'Prescription Image',
            'prescrption_text' => 'Prescrption Text',
            'summary' => 'Reports Summary',
            'status' => 'Status',
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
    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_fk_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatientTests()
    {
        return $this->hasMany(PatientTests::className(), ['patient_report_fk_id' => 'id']);
    }

    /**
     * @return Reports|null
     */
    public function createReport()
    {
        if (!$this->validate()) {
            return null;
        }

        $model = new Reports();
        $model->patient_fk_id = $this->patient_fk_id;
        return $model->save() ? $model : null;
    }

    /**
    * Sends an email with a report pdf attached.
    *
    * @return boolean whether the email was send
    */
    public function emailReport()
    {

    }
}

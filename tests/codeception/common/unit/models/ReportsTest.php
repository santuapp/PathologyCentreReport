<?php

namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\Reports;
use common\models\Patient;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\fixtures\PatientFixture;

/**
 * Reports test
 */
class ReportsTest extends DbTestCase
{
    use Specify;

    public function setUp()
    {
        parent::setUp();

        Yii::configure(Yii::$app, [
            'components' => [
                'user' => [
                    'class' => 'yii\web\User',
                    'identityClass' => 'common\models\User',
                ],
            ],
        ]);
    }

    public function testCorrectCreateReport()
    {
        $patient = Patient::find()->select('id')->orderBy('id')->one();
        $model = new Reports([
            'patient_fk_id' => $patient->id,
            'exam' => 'some_exam',
            'referred_doctor' => 'some_doctor_name',
            'doctor_specialization' => 'doctor_specialization',
            'prescrption_text' => 'details_of_test',
        ]);
        $model->createReport();

        $this->assertInstanceOf('common\models\Reports',$model,'report should be created');

        expect('name should be correct', $model->exam)->equals('some_exam');
        expect('referred doctor name should be correct', $model->referred_doctor)->equals('some_doctor_name');
    }

    public function testNotCorrectAddReport()
    {
        $model = new Reports([
            'exam' => '',
            'referred_doctor' => 'some_doctor_name',
            'doctor_specialization' => 'doctor_specialization',
            'prescrption_text' => 'details_of_test',
        ]);

        expect('exam is empty, reports should not be created', $model->createReport())->null();
    }

    public function fixtures()
    {
        return [
            /*'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/codeception/common/fixtures/data/init_login.php',
            ],*/
            'patientUser' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/patientUser.php',
            ],
            'patient' => [
                'class' => PatientFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/patient.php',
            ],
        ];
    }

}
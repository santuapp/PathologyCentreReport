<?php

namespace tests\codeception\common\unit\models;

use common\models\PatientTests;
use common\models\TestsType;
use tests\codeception\common\fixtures\ReportsFixture;
use tests\codeception\common\fixtures\TestsTypeFixture;
use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\Reports;
use common\models\Patient;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\fixtures\PatientFixture;

/**
 * Patient test
 */
class PatientTestsTest extends DbTestCase
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

    public function testCorrectPatientTest()
    {
        $report = Reports::find()->select('id')->orderBy('id')->one();
        $testType = TestsType::find()->select('id')->orderBy('id')->one();
        $model = new PatientTests([
            'patient_report_fk_id' => isset($report)?$report->id:0,
            'tests_type_fk_id' => isset($testType)?$testType->id:0,
            'test_result' => '100 ml',
        ]);
        $model->createPatientTests();

        $this->assertInstanceOf('common\models\PatientTests',$model,'patient tests should be created');

        expect('test result should be correct', $model->test_result)->equals('100 ml');
    }

    public function testNotCorrectPatientTest()
    {
        $model = new PatientTests([
            'patient_report_fk_id' => '',
            'tests_type_fk_id' => '',
            'test_result' => '100 ml',
        ]);

        expect('report id is empty, patient tests should not be created', $model->createPatientTests())->null();
    }

    public function fixtures()
    {
        return [
            'testsType' => [
                'class' => TestsTypeFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/testsType.php',
            ],
            'patientUser' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/patientUser.php',
            ],
            'patient' => [
                'class' => PatientFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/patient.php',
            ],
            'reports' => [
                'class' => ReportsFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/reports.php',
            ],
        ];
    }

}
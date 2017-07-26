<?php

namespace tests\codeception\common\unit\models;

use tests\codeception\common\fixtures\PatientFixture;
use Yii;
use tests\codeception\common\unit\DbTestCase;
use tests\codeception\common\fixtures\UserFixture;
use Codeception\Specify;
use common\models\User;
use common\models\Patient;

/**
 * Patient test
 */
class PatientTest extends DbTestCase
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

    public function testCorrectAddPatient()
    {
        $user = User::find()->where(['user_type' => 3])->orderBy('id')->one();
        $model = new Patient([
            'user_fk_id' => $user->id,
            'pass_code' => mt_rand(100000, 999999),
            'gender' => 'm',
            'dob' => '1991-02-11',
        ]);

        $model->addPatient();

        $this->assertInstanceOf('common\models\Patient',$model,'patient should be valid');

        /*expect('name should be correct', $user->name)->equals('some_name');
        expect('email should be correct', $user->email)->equals('some_email@example.com');*/
        expect('dob should be correct', $model->dob)->equals('1991-02-11');
    }

    public function testNotCorrectAddPatient()
    {
        $model = new Patient([
            'pass_code' => '',
            'gender' => 'm',
            'dob' => '1991-02-11',
        ]);

        expect('pass code is empty, patient should not be created', $model->addPatient())->null();
    }

    public function testDuplicatePassCode()
    {
        $model = new Patient([
            'pass_code' => 'PC1234',
            'gender' => 'm',
            'dob' => '1991-02-11',
        ]);

        expect('pass code is duplicate, patient should not be created', $model->addPatient())->null();
    }

    public function fixtures()
    {
        return [
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
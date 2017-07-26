<?php

namespace tests\codeception\common\unit\models;

use Yii;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\models\TestsType;

/**
 * Tests Type test
 */
class TestsTypeTest extends DbTestCase
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

    public function testCorrectCreateTestsType()
    {
        $model = new TestsType([
            'name' => 'test_name',
            'reference_interval' => 'reference_interval',
        ]);
        $testType = $model->createTestsType();

        $this->assertInstanceOf('common\models\TestsType',$testType,'tests type should be created');

        expect('name should be correct', $testType->name)->equals('test_name');
        expect('reference interval should be correct', $testType->reference_interval)->equals('reference_interval');
    }

    public function testNotCorrectCreateTestsType()
    {
        $model = new TestsType([
            'name' => '',
            'reference_interval' => 'reference_interval',
        ]);

        expect('name is empty, tests type should not be created', $model->createTestsType())->null();
    }

    public function fixtures()
    {
        return [
        ];
    }
}
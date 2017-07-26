<?php

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * User fixture
 */
class ReportsFixture extends ActiveFixture
{
    public $modelClass = 'common\models\Reports';
    public $depends = ['tests\codeception\common\fixtures\PatientFixture'];
}
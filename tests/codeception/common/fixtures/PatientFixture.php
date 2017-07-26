<?php

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * User fixture
 */
class PatientFixture extends ActiveFixture
{
    public $modelClass = 'common\models\Patient';
    public $depends = ['tests\codeception\common\fixtures\UserFixture'];
}
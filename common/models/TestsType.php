<?php

namespace common\models;

use Codeception\Lib\Generator\Test;
use Yii;

/**
 * This is the model class for table "tests_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $reference_interval
 * @property string $specimen_type
 * @property string $testing_frequency
 * @property string $comments
 * @property integer $status
 * @property integer $is_deleted
 */
class TestsType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tests_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'reference_interval'], 'required'],
            [['name', 'reference_interval', 'specimen_type', 'testing_frequency', 'comments'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'reference_interval' => 'Reference Interval',
            'specimen_type' => 'Specimen Type',
            'testing_frequency' => 'Testing Frequency',
            'comments' => 'Comments',
        ];
    }

    public function createTestsType()
    {
        if(!$this->validate()) {
            return null;
        }

        $model = new TestsType();
        $model->name = $this->name;
        $model->reference_interval = $this->reference_interval;
        return $model->save() ? $model : null;
    }
}

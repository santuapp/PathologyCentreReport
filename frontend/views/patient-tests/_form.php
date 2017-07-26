<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PatientTests */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-tests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'patient_report_fk_id')->textInput() ?>

    <?= $form->field($model, 'tests_type_fk_id')->textInput() ?>

    <?= $form->field($model, 'test_result')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

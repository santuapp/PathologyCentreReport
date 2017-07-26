<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reports-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12">
            <label>Search Patient</label>
            <?= AutoComplete::widget([
                'model' => $model,
                'attribute' => "patient",
                'id' => "patient",
                'clientOptions' => [
                    'source' => $users,
                    'autoFill' => true,
                    'minLength' => '1',
                    'select' => new JsExpression("function(event, ui) {
                            console.log(ui.item.id);
                                $('#reports-patient_fk_id').val(ui.item.id);
                            }")
                ],
                'options' => [
                    'placeholder' => 'Find a Patient..',
                    'class' => 'form-control',
                    'value' => isset($model->patient->user) ? $model->patient->user->name : '',
                ],
            ]);
            ?>
            <div class="help-block"></div>
            <?= Html::activeHiddenInput($model, "patient_fk_id")?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'exam')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'referred_doctor')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'sample_no')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'doctor_specialization')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'prescrption_text')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>
        </div>

        <div class="clearfix"></div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php // echo $form->field($model, 'prescription_image')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>

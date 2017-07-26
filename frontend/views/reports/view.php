<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */

$this->title = $model->exam;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="report">

        <div class="row header">

            <div class="col-sm-6">
                <div class="well">
                    <p>Name: <strong><?= isset($model->patient->user)?$model->patient->user->name:"-"; ?></strong></p>
                    <p>Gender: <?php if(isset($model->patient)) {
                            if($model->patient->gender == 'm') {
                                echo "Male";
                            } else {
                                echo "Female";
                            }
                        } ?>
                    </p>
                    <p>Age: <?= $model->patient->dob;?></p>
                    <p>Email: <?= isset($model->patient->user)?$model->patient->user->email:"-"; ?></p>
                </div>
            </div><!--/col-->

            <div class="col-sm-6">
                <div class="well">
                    <p>Sample Number: <strong><?= $model->sample_no;?></strong></p>
                    <p>Referred Doctor: <strong><?= $model->referred_doctor;?></strong></p>
                    <p>Reported On: <?= date_format(date_create($model->created_date),"d M Y, H:i")?></p>
                    <p>Lab No: Y000751881</p>
                </div>
            </div><!--/col-->

            <?php if(!empty($model->summary)): ?>
            <div class="col-md-12 notice">
                <h3>Summary</h3>
                <div class="well">
                    <?= nl2br($model->summary)  ;?>
                </div>
            </div><!--/col-->
            <?php endif; ?>

        </div><!--/row-->
        <?php if($dataProvider->getTotalCount() > 0): ?>
        <table class="table table-striped table-responsive">
            <thead>
            <tr>
                <th class="center">#</th>
                <th>Test Name</th>
                <th>Result</th>
                <th class="center">Reference Interval</th>
            </tr>
            </thead>
            <tbody>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'summary' => '',
                'itemView' => '_details',
                'emptyText' => '',
            ])?>
            </tbody>
        </table>
        <?php endif; ?>
        <div class="row">

            <?php if(Yii::$app->user->identity->user_type == Yii::$app->params['user.userTypeOperator']) { ?>
                <div class="col-md-12 recap" style="text-align: center">
                    <?php if($dataProvider->getTotalCount() > 0) { ?>
                        <a href="<?= Yii::$app->urlManager->createUrl(['reports/download-report', 'id'=>$model->id]); ?>" class="btn btn-info"><i class="fa fa-print"></i> Download Report</a>
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addMore"><i class="fa fa-usd"></i> Add More Test</a>
                    <?php } else { ?>
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addMore"><i class="fa fa-usd"></i> Add Test in Report</a>
                    <?php } ?>
                </div><!--/col-->
            <?php } else { ?>
                <div class="col-md-12 recap" style="text-align: center">
                    <a href="<?= Yii::$app->urlManager->createUrl(['reports/download-report', 'id'=>$model->id]); ?>" class="btn btn-info"><i class="fa fa-print"></i> Download Report</a>
                    <a href="#" class="btn btn-success" id="mail-report"> Mail Report</a>
                </div><!--/col-->
            <?php } ?>

        </div><!--/row-->

    </div>

    <!-- Modal -->
    <div id="addMore" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Tests</h4>
                </div>
                <div class="modal-body">
                    <div class="patient-tests-form">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($patientTests, 'patient_report_fk_id')->hiddenInput(['value' => $model->id])->label(false) ?>

                        <?php $dropDownTest = ArrayHelper::map($testTypes,'id','name'); ?>
                        <?= $form->field($patientTests, 'tests_type_fk_id')->dropDownList($dropDownTest,['prompt'=>'Select Test']); ?>

                        <?= $form->field($patientTests, 'test_result')->textInput(['maxlength' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton($patientTests->isNewRecord ? 'Create' : 'Update', ['class' => $patientTests->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
    $('#mail-report').on('click', function(e) {
        var t = $(this);
        t.prop('disabled',true);
        t.text('Sending Mail...');

        $.ajax({
            url: "<?= Yii::$app->urlManager->createUrl(['reports/mail-report']); ?>",
            type: 'GET',
            data: {id: "<?= $model->id;?>"},
            async: false,
            cache: false,
            success: function(data) {
                t.prop('disabled',false);
                t.text('Mail Sent');
            },
            error: function() {
                alert("We are facing some issues right now. Please contact admin.");
            }

        });
        e.preventDefault();
    })
</script>

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
                    <p>Age: <?php
                        if(isset($model->patient->dob)) {
                            echo date_diff(date_create($model->patient->dob), date_create('now'))->y;
                        }
                        ?></p>
                    <p>Email: <?= isset($model->patient->user)?$model->patient->user->email:"-"; ?></p>
                </div>
            </div><!--/col-->

            <div class="col-sm-6">
                <div class="well">
                    <p>Referred Doctor: <strong><?= $model->referred_doctor;?></strong></p>
                    <p>Sample Number: <strong><?= $model->sample_no;?></strong></p>
                    <p>Reported On: <?= date_format(date_create($model->created_date),"d M Y, H:i")?></p>
                    <p>Lab No: Y000751881</p>
                </div>
            </div><!--/col-->

            <?php if(!empty($model->summary)): ?>
            <div class="col-md-12 notice">
                <h3>Summary</h3>
                <div class="well">
                    <?= $model->summary;?>
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

            <div class="col-md-12 recap" style="text-align: center">
                <a href="<?= Yii::$app->urlManager->createUrl(['site/download-report', 'id'=>$model->id]); ?>" class="btn btn-info"><i class="fa fa-print"></i> Download Report</a>
            </div><!--/col-->

        </div><!--/row-->

    </div>
</div>
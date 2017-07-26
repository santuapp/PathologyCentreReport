<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Pathology Labs - Dashboard';
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3>Recent Reports Generated</h3>
                    <div class="box-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'exam',
                                [
                                    'label' => 'Patient',
                                    'value' => function ($model) {
                                        if(isset($model->patient->user)) {
                                            return $model->patient->user->name;
                                        } else {
                                            return '-';
                                        }
                                    },
                                ],
                                'referred_doctor',
                                //'prescription_image',
                                // 'prescrption_text:ntext',
                                // 'summary:ntext',
                                // 'status',
                                // 'is_deleted',
                                // 'created_by',
                                // 'created_date',
                                // 'modified_by',
                                // 'modified_date',

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{download}{view}',
                                    'buttons' => [
                                        'download' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-large glyphicon-download"></span>', 'site/download-report?id='.$model->id, [
                                                'title' => 'Download Report',
                                            ]);
                                        },
                                    ],
                                ],
                            ],
                        ]); ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
</section><!-- /.content -->
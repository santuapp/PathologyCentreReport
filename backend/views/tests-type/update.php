<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TestsType */

$this->title = 'Update Tests Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tests Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div><!-- /.box-header -->

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div><!-- /.col-->
    </div><!-- ./row -->
</section><!-- /.content -->
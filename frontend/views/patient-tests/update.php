<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PatientTests */

$this->title = 'Update Patient Tests: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Patient Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="patient-tests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PatientTests */

$this->title = 'Create Patient Tests';
$this->params['breadcrumbs'][] = ['label' => 'Patient Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-tests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Patient */

$this->title = 'Add New Patient';
$this->params['breadcrumbs'][] = ['label' => 'Patients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user
    ]) ?>

</div>

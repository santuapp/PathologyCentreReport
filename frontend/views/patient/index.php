<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Patients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add New Patient', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'value' => function ($model) {
                    if(isset($model->user)) {
                        return $model->user->name;
                    } else {
                        return '-';
                    }
                },
                'filter' => Html::activeTextInput($searchModel, 'name',['class'=>'form-control']),
            ],
            'pass_code',
            [
                'attribute' => 'gender',
                'value' => function ($model) {
                    if($model->gender == 'm') {
                        return 'Male';
                    } else {
                        return 'Female';
                    }
                },
                'filter' => Html::activeDropDownList($searchModel, 'gender', array("m"=>"Male", "f"=>"Female"),['class'=>'form-control','prompt' => 'Select']),
            ],
            // 'height',
            // 'weight',
            // 'blood_group',
            // 'address:ntext',
            // 'created_by',
            // 'created_date',
            // 'modified_by',
            // 'modified_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

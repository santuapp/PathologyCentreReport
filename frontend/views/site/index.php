<?php

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Pathology Lab Reporting System';
?>
<style>
    .error-summary {
        margin-top: 60px;
        width: 350px;
        float: right;
    }
</style>
<div class="site-index">
    <?php if(Yii::$app->user->isGuest) { ?>
        <div class="jumbotron">
            <h1>Lookup at your report here!</h1>

            <p class="lead">"Care is when you start with your own health"</p>
        </div>

        <section class="block">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => ['patient-login'],
                'fieldConfig' => [
                    'template' => "{input}",
                    'options' => [
                        'tag'=>'span'
                    ]
                ]
            ]); ?>
                <div class="search">
                    <div class="search-icon"></div>
                    <?= AutoComplete::widget([
                        'attribute' => "patient",
                        'id' => "patient",
                        'clientOptions' => [
                            'source' => $users,
                            'autoFill' => true,
                            'minLength' => '1',
                            'select' => new JsExpression("function(event, ui) {
                                console.log(ui.item.id);
                                    $('#loginform-email').val(ui.item.email);
                                }")
                        ],
                        'options' => [
                            'placeholder' => 'Enter Patient Name..',
                            'class' => 'form-control',
                        ],
                    ]);
                    ?>
                    <?= $form->field($model, 'email')->hiddenInput()->label(false) ?>
                    <div class="location-icon"></div>
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter Pass Code', 'class' => 'form-control location'])->label(false) ?>
                    <input value="SEARCH" class="search-button btn btn-primary" type="submit">
                </div>
            <?php echo $form->errorSummary($model); ?>
            <?php ActiveForm::end(); ?>
        </section>

    <?php } else { ?>

        <div class="jumbotron">
            <h1>Welcome to Pathology Labs!</h1>

            <p class="lead">"Care is when you start with your own health"</p>
            <p><a class="btn btn-lg btn-success" href="<?= Yii::$app->urlManager->createUrl('reports/index'); ?>">View Reports</a></p>
        </div>

        <div class="body-content">

            <div class="row">
                <div class="col-lg-4">
                    <h3> What is Pathology? What is its purpose?</h3>

                    <p>A pathology report is a medical document written by a pathologist. A pathologist is a doctor who specializes in interpreting laboratory tests and evaluating cells, tissues, and organs to diagnose disease. The report gives a diagnosis based on the pathologist’s examination of a sample of tissue taken from the patient’s tumor.</p>
                    <p>Pathologists look for abnormalities within samples, but quite often these tests are performed to confirm everything is OK.</p>
                </div>
                <div class="col-lg-4">
                    <h3>Who all are a parts of pathology to demonstrate? How can it perform as a successful completion of pathology test? </h3>

                    <p>Pathology is a journey that starts with patient, doctors and specimen. </p>
                    <p>Every time you give a blood, stool, urine or tissue sample, it is analysed by a pathologist or pathology scientist known as a biomedical or clinical scientist, depending on their skills and qualifications. All of them play a vital role to make it provide a successful report of pathology.</p>

                </div>
                <div class="col-lg-4">
                    <h3>How can we understand that the report is good/normal/bad? Or How can we read on our own to understand the pathology report?</h3>

                    <p>Honestly you cannot understand the pathology report on your own. However, you should expect the report to contain highly technical medical terms. Ask your doctor to explain the pathology report results and what they mean.</p>
                </div>
            </div>

        </div>
    <?php } ?>
</div>

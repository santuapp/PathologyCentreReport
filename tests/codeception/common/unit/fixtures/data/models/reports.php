<?php
$patient = \common\models\Patient::find()->select('patient_details.id')->joinWith('user')->where(['user.user_type' => 3])->orderBy('patient_details.id')->one();
return [
    [
        'patient_fk_id' => isset($patient)?$patient->id:0,
        'exam' => 'Lab Exam Name',
        'referred_doctor' => 'Dr Subramaniam',
        'doctor_specialization' => 'MD (Biochemistry)',
        'prescrption_text' => 'Description for tests',
        'created_date' => date("Y-m-d H:i:s"),
        'modified_date' => date("Y-m-d H:i:s"),
    ],
];

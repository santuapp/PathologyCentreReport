<?php
$user = \common\models\User::find()->select('id')->where(['user_type' => 3])->orderBy('id')->one();
return [
    [
        'user_fk_id' => isset($user)?$user->id:0,
        'pass_code' => 'PC1234',
        'gender' => 'm',
        'dob' => '1991-02-11',
        'created_date' => '2016-06-02 18:08:32',
        'modified_date' => '2016-06-02 18:08:32',
    ],
];

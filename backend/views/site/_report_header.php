<div style="width: 100%; margin: 0 auto; text-align: center">
    <img src="<?= Yii::$app->urlManager->baseUrl."/images/pathology-pic.jpg" ; ?>">
</div>
<table cellspacing="0" cellpadding="0" style="width:100%;" >
    <tr>
        <td class="tr0 td0">
            <p class="p0 ft0">Name</p>
        </td>
        <td class="tr0 td1">
            <p class="p1 ft1"><strong><?= isset($model->patient->user)?$model->patient->user->name:"-"; ?></strong></p>
        </td>
        <td class="tr0 td0">
            <p class="p5 ft0">Referred By</p>
        </td>
        <td class="tr0 td1">
            <p class="p1 ft1"><strong><?= $model->referred_doctor;?></p>
        </td>
        <td class="tr0 td1">
            <p class="p1 ft1"><strong><?= $model->sample_no;?></p>
        </td>
    </tr>
    <tr>
        <td class="tr0 td5">
            <p class="p2 ft0">Gender</p>
        </td>
        <td class="tr0 td6">
            <p class="p4 ft0">
                <?php if(isset($model->patient)) {
                    if($model->patient->gender == 'm') {
                        echo "Male";
                    } else {
                        echo "Female";
                    }
                } ?>
            </p>
        </td>
        <td class="tr0 td2">
            <p class="p2 ft0">Lab No: </p>
        </td>
        <td colspan="2" class="tr0 td13">
            <p class="p2 ft0">
                <nobr>Y000751881</nobr>
            </p>
        </td>
    </tr>

    <tr>
        <td class="tr0 td2">
            <p class="p0 ft0">Age</p>
        </td>
        <td class="tr0 td3">
            <p class="p2 ft0">
                <?php
                if(isset($model->patient->dob)) {
                    echo date_diff(date_create($model->patient->dob), date_create('now'))->y;
                }
                ?>
            </p>
        </td>
        <td class="tr0 td2">
            <p class="p2 ft0">Reported On</p>
        </td>
        <td class="tr0 td3">
            <p class="p2 ft0"><?= date_format(date_create($model->created_date),"d M Y, H:i")?></p>
        </td>
    </tr>
</table>
<br>
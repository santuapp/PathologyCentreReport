<br>
<table cellspacing="0" cellpadding="0" style="width: 100%">
    <tr>
        <th width="10" align="left">
            <p>S.No.</p>
        </th>
        <th width="40" align="left">
            <p>Test Name</p>
        </th>
        <th width="25" align="left">
            <p>Result</p>
        </th>
        <th width="25" align="left">
            <p>Reference Interval</p>
        </th>
    </tr>

    <?php if(isset($model->patientTests)) {
        foreach($model->patientTests as $key => $test) {
            ?>
            <tr>
                <td><?= $key+1;?></td>
                <td><?= isset($test->testsType)?$test->testsType->name:'-'; ?></td>
                <td><?= $test->test_result;?></td>
                <td><?= isset($test->testsType)?$test->testsType->reference_interval:'-';?></td>
            </tr>
            <?php
        }
    } ?>
</table>
<br><br>
<table cellspacing="0" cellpadding="0" class="t1">
    <tr>
        <td class="tr6 td18">
            <p class="p3 ft2">&nbsp;</p>
        </td>
        <td class="tr6 td19">
            <p class="p3 ft2">&nbsp;</p>
        </td>
        <td class="tr6 td20">
            <p class="p3 ft8">********** <span class="ft0">END OF REPORT </span>**********</p>
        </td>
        <td class="tr6 td21">
            <p class="p3 ft2">&nbsp;</p>
        </td>
    </tr>
    <br>
    <tr>
        <td class="tr9 td17">
            <p class="p13 ft0">Processed by :-</p>
        </td>
        <td class="tr9 td18">
            <p class="p14 ft0"><?= isset($model->createdBy)?$model->createdBy->name:'-'; ?></p>
        </td>
        <td class="tr9 td20">
            <p class="p3 ft2">&nbsp;</p>
        </td>
        <td class="tr9 td21">
            <p class="p15 ft9"><?= $model->referred_doctor;?></p>
        </td>
        <td class="tr9 td21">
            <p class="p15 ft9"><?= $model->sample_no;?></p>
        </td>
    </tr>
    <tr>
        <td class="tr10 td18">
            <p class="p3 ft2">&nbsp;</p>
        </td>
        <td class="tr10 td19">
            <p class="p3 ft2">&nbsp;</p>
        </td>
        <td class="tr10 td20">
            <p class="p3 ft2">&nbsp;</p>
        </td>
        <td class="tr10 td21">
            <p class="p15 ft10"><?= $model->doctor_specialization?></p>
        </td>
    </tr>
</table>
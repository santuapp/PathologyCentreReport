<tr>
    <td class="center"><?= $index+1;?></td>
    <td class="left"><?= isset($model->testsType)?$model->testsType->name:'-'; ?></td>
    <td class="left"><?= $model->test_result;?></td>
    <td class="left"><?= isset($model->testsType)?$model->testsType->reference_interval:'-';?></td>
</tr>
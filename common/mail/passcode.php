<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
<div>
    Dear <?= isset($model->user)?$model->user->name:''; ?> <br><br/>

    <p>Please use the following pass-code to view your report: <?= $model->pass_code;?></p>
</div>
<!-- End of wrapper table -->
</body>
</html>

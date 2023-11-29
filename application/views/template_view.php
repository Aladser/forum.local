<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageName; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" href="http://buscor.local/application/images/icon.png">
    <link rel="stylesheet" href="http://buscor.local/application/css/reset_styles.css">
    <link rel="stylesheet" href="http://buscor.local/application/css/template.css">
    <?php if (!empty($content_css)) { ?>
        <link rel="stylesheet" href="http://buscor.local/application/css/<?php echo $content_css; ?>">
    <?php } ?>
</head>
<body>

<header><h3 class='text-center p-4 text-white bg-c4c4c4'><?php echo $pageName; ?></h3></header>
<?php include $content_view; ?>
<?php if (!empty($content_js)) { ?>
    <script type='text/javascript' src="http://buscor.local/application/js/<?php echo $content_js; ?>"></script>
<?php } ?>
</body>
</html>

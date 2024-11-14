<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        if (!empty($add_head)) {
            echo $add_head;
        }
    ?>
    <title><?php echo $page_name; ?></title>
    <link rel="icon" href="/static/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/static/css/reset_styles.css">
    <link rel="stylesheet" href="/static/css/template.css">
    
    <?php if (!empty($content_css)) { ?>
        <!-- css -->
        <link rel="stylesheet" href="/static/css/<?php echo $content_css; ?>">
    <?php } ?>

    <?php if (!empty($content_js)) { ?>
        <!-- js -->
        <?php foreach ($content_js as $script) { ?> 
            <script type='text/javascript' src="/static/js/<?php echo $script; ?>" defer></script> 
        <?php } ?>
    <?php } ?>
</head>
<body>

<header class='mb-4'>
    <div class='theme-bg-сolor text-center text-white d-flex justify-content-between'>
        <a href="/" class="text-decoration-none text-light page-name-header p-3 fw-bold">ФОРУМ</a>
    </div>
</header>

<?php include $content_view; ?>
</body>
</html>

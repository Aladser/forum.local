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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" href="http://<?php echo $site_address; ?>/public/images/icon.png">
    <link rel="stylesheet" href="http://<?php echo $site_address; ?>/public/css/reset_styles.css">
    <link rel="stylesheet" href="http://<?php echo $site_address; ?>/public/css/template.css">
    <!-- css -->
    <?php if (!empty($content_css)) { ?>
        <link rel="stylesheet" href="http://<?php echo $site_address; ?>/public/css/<?php echo $content_css; ?>">
    <?php } ?>
    <!-- js -->
    <?php if (!empty($content_js)) { ?>
    <?php foreach ($content_js as $script) {?>
        <script type='text/javascript' src="http://<?php echo $site_address; ?>/public/js/<?php echo $script; ?>" defer></script>
    <?php }?>
<?php } ?>
</head>
<body>

<header class='mb-4'>
    <div class='text-center text-white bg-theme d-flex justify-content-between'>
        <?php if (!empty($data)) {?>
            <?php if (array_key_exists('login', $data)) {?>
                <h3 class='p-4 w-90'><?php echo $page_name; ?></h3>
                <div class='d-flex justify-content-end'>
                    <div class='d-flex align-items-center justify-content-between px-5 border-start border-end border-2 border-light'><?php echo $data['login']; ?></div>
                    <a href="/main?logout=true" class='ref-color text-decoration-none'>
                        <div class='h-100 d-flex align-items-center px-4'>Выйти</div>
                    </a>
                </div>
            <?php } else {?>
                <h3 class='p-4 w-100'><?php echo $page_name; ?></h3>
            <?php } ?>
        <?php } else { ?>
            <h3 class='p-4 w-100'><?php echo $page_name; ?></h3>
        <?php } ?>
    </div>
</header>

<?php include $content_view; ?>
</body>
</html>

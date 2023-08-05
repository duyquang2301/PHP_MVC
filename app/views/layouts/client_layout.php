<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website</title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/style.css" />
</head>

<body>
    <?php
    $this->render('blocks/header');
    $this->render($content);
    $this->render('blocks/footer');
    ?>



    <script type="text/script" src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/script.js"></script>
</body>

</html>
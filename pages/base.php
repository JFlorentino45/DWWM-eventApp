<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= CSS ?>/style.css">
        <link rel="stylesheet" href="<?= $pageLink ?>">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <title>Event Site</title>
</head>
<body>
<?php
        include TEMPLATE . '/_header.php';
        $router->getPage();
        include TEMPLATE . '/_footer.php'; 
?>
</body>
</html>
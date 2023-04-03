<?php
include './config/config.php';
$page = isset($_GET["page"]) ? $_GET["page"] : "home";
$pageLink = CSS . "/" . $page . ".css";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS ?>/style.css">
    <title>Home</title>
</head>
<body>
<?php
        include TEMPLATE . '/_header.php';
        if(file_exists(PAGES . $page . ".php"))
        {
        include PAGES . $page . ".php";
        } else
        {
            include TEMPLATE . "/404.php";
        }
        include TEMPLATE . '/_footer.php'; 
    ?>
</body>
</html>
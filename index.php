<?php
require_once './config/config.php';
require_once './classes/Router.php';

$page = isset($_GET["page"]) ? $_GET["page"] : "home";
$pageLink = CSS . "/" . $page . ".css";
$router = new Router();
include './pages/base.php';


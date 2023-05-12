<?php
class Router
{
    private $page;
    private $allowedPages = ["home", "login", "editEvent", "editPassword", "editUser", "editVenue", "event", "logout", "myEventsO", "myEventsP", "newEvent", "newUser", "newVenue", "profile", "removeEvent", "users", "venue", "venues"];

    public function __construct()
    {
        $userPage = isset($_GET["page"]) ? $_GET["page"] : "home";
        $this->page = in_array($userPage, $this->allowedPages) ? $userPage : PAGES . "template/404.php";
        ;
    }
    public function getPage()
    {
        $pagePath = PAGES . $this->page . ".php";
        if(file_exists($pagePath)){
            include $pagePath;
        } else{
            include PAGES . "template/404.php";
        }
    }
}
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
        $allowedPaths = [PAGES . "home.php", PAGES . "login.php", PAGES . "editEvent.php", PAGES . "editPassword.php", PAGES . "editUser.php", PAGES . "editVenue.php", PAGES . "event.php", PAGES . "logout.php", PAGES . "myEventsO.php", PAGES . "myEventsP.php", PAGES . "newEvent.php", PAGES . "newVenue.php", PAGES . "profile.php", PAGES . "removeEvent.php", PAGES . "users.php", PAGES . "venue.php", PAGES . "venues.php"];
        if(in_array($pagePath, $allowedPaths) && file_exists($pagePath)){
            include $pagePath;
        } else{
            include PAGES . "template/404.php";
        }
    }
}
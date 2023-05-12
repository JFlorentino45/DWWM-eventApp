<?php
class Router
{
    private $page;

    public function __construct()
    {
        $this->page = strip_tags(htmlspecialchars(isset($_GET["page"]) ? $_GET["page"] : "home"));
        ;
    }
    public function getPage()
    {
        if(file_exists(strip_tags(htmlspecialchars((PAGES . $this->page . ".php"))))){
            include PAGES . $this->page . ".php";
        } else{
            include PAGES . "page404.php";
        }
    }
}
<?php
class Router
{
    private $page;

    public function __construct()
    {
        $this->page = isset($_GET["page"]) ? $_GET["page"] : "home";
        ;
    }
    public function getPage()
    {
        if(file_exists(PAGES . $this->page . ".php")){
            include PAGES . $this->page . ".php";
        } else{
            include PAGES . "page404.php";
        }
    }
}
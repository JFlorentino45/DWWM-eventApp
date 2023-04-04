<?php 
function getRole() {
    if(isset($_SESSION['role'])){
        return $_SESSION['role'];
    } else{
        return 'guest';
    }
}

function getUserID() {
    if(isset($_SESSION['userID'])){
        return $_SESSION['userID'];
    }
}
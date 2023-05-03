<?php
class AccountInfo
{
    public static function getRole()
    {
        if (isset($_SESSION['role'])) {
            return $_SESSION['role'];
        } else {
            return 'guest';
        }
    }

    public static function getUserID()
    {
        if (isset($_SESSION['userID'])) {
            return $_SESSION['userID'];
        }
    }
}

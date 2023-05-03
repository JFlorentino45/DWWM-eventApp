<?php
class CheckUID
{
    public static function GetuID($userID, $conn){
        $stmt = $conn->prepare("SELECT userID FROM user WHERE userID = :userID");
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$result) {
            header("Location: ". TEMPLATE . '404.php');
            exit;
        }
    }
}
<?php
class CheckVID
{
    public static function GetvID($venueID, $conn){
        $stmt = $conn->prepare("SELECT venueID FROM venue WHERE venueID = :venueID");
        $stmt->bindParam(':venueID', $venueID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$result) {
            header("Location: ". TEMPLATE . '404.php');
            exit;
        }
    }
}
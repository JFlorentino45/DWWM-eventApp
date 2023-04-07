<?php
function GeteID($eventID, $conn){
    $stmt = $conn->prepare("SELECT eventID FROM event WHERE eventID = :eventID");
    $stmt->bindParam(':eventID', $eventID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$result) {
    header("Location: ". TEMPLATE . '404.php');
    exit;
}
}
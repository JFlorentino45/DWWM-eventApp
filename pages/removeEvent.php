<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$role = getRole();
$userID = getUserID();
$eventID = $_GET['id'];

try {
    $stmt = $conn->prepare("CALL removeEventGetName(:eventID)");
    $stmt->bindParam(':eventID', $eventID);
    $stmt->execute();
    $event = $stmt->fetch();
    $stmt = $conn->prepare("CALL removeEventCount(:userID, :eventID)");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':eventID', $eventID);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    if($count > 0 || $role == 'admin'){
        if(isset($_POST['remove'])) {
        $stmt = $conn->prepare("CALL removeEventDelete(:eventID)");
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();
        header('Location: index.php?page=myEventsO');
        }
    } else{
        header("Location: ". TEMPLATE . '403.php');
    }
} catch(PDOException $e){
    echo "Error executing the stored procedure: " . $e->getMessage();
}
?>

<main>
    <h2>Are you sure you want to delete '<?php echo htmlspecialchars($event['eventName']) ?>'</h2>
    <p><form method="post">
        <input type="submit" name="remove" value="Yes">
    </form>
    <a href="index.php?page=myEventsO"><button>No</button></a></p>
</main>
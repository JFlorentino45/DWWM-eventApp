<?php 
include('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
$role = getRole();
$venueID = $_GET['id'];

if($role == 'admin'){
    $stmt = $conn->prepare("SELECT * FROM venue WHERE venueID = :id");
    $stmt->execute(['id' => $venueID]);
    $venue = $stmt->fetch();
    
    if(isset($_POST['submit'])) {
        // Get the event details from the form
        $venueName = $_POST['venueName'];
        $venueAddress = $_POST['venueAddress'];
        $venuePostalCode = $_POST['venuePostalCode'];
        $venueImg = $_POST['venueImg'];
    
        $stmt = $conn->prepare('CALL editVUpdate(:venueName, :venueAddress, :venuePostalCode, :venueImg, :venueID)');
        $stmt->bindParam(':venueName', $venueName);
        $stmt->bindParam(':venueAddress', $venueAddress);
        $stmt->bindParam(':venuePostalCode', $venuePostalCode);
        $stmt->bindParam(':venueImg', $venueImg);
        $stmt->bindParam(':venueID', $venueID);
        $stmt->execute();
    
        header('Location: index.php?page=venues');
        exit();
    }
    if(isset($_POST['delete'])) {
        $stmt = $conn->prepare('CALL editVDelete(:venueID)');
        $stmt->bindParam(':venueID', $venueID);
        $stmt->execute();

        header('Location: index.php?page=venues');
        exit();
    }
} else{
    header("Location: ". TEMPLATE . '403.php');
}
?>

<main>
    <h1>Edit Venue</h1>
    <form method="post">
        <label>Venue Name:</label>
        <input type="text" name="venueName" value="<?php echo htmlspecialchars($venue['venueName']); ?>">
        <label>Venue Address:</label>
        <input type="text" name="venueAddress" value="<?php echo htmlspecialchars($venue['venueAddress']); ?>">
        <label>Venue Postal Code:</label>
        <input type="text" name="venuePostalCode" value="<?php echo htmlspecialchars($venue['venuePostalCode']); ?>">
        <label>Venue Image URL:</label>
        <input type="text" name="venueImg" value="<?php echo htmlspecialchars($venue['venueImg']); ?>">
        <input type="submit" name="submit" value="Edit Venue">
        <input type="submit" name="delete" value="Delete Venue">
    </form>
</main>
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
    
        $stmt = $conn->prepare("UPDATE venue SET venueName = :venueName, venueAddress = :venueAddress, venuePostalCode = :venuePostalCode, venueImg = :venueImg WHERE venueID = :venueID");
        $stmt->bindParam(':venueName', $venueName);
        $stmt->bindParam(':venueAddress', $venueAddress);
        $stmt->bindParam(':venuePostalCode', $venuePostalCode);
        $stmt->bindParam(':venueImg', $venueImg);
        $stmt->bindParam(':venueID', $venueID);
        $stmt->execute();
    
        header('Location: index.php?page=venues');
        exit();
    }
} else{
    header("Location: ". TEMPLATE . '404.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Venue</title>
</head>
<body>
    <h1>Edit Venue</h1>
    <form method="post">
        <label>Venue Name:</label>
        <input type="text" name="venueName" value="<?php echo $venue['venueName']; ?>">
        <label>Venue Address:</label>
        <input type="text" name="venueAddress" value="<?php echo $venue['venueAddress']; ?>">
        <label>Venue Postal Code:</label>
        <input type="text" name="venuePostalCode" value="<?php echo $venue['venuePostalCode']; ?>">
        <label>Venue Image URL:</label>
        <input type="text" name="venueImg" value="<?php echo $venue['venueImg']; ?>">
        <input type="submit" name="submit" value="Edit Venue">
    </form>
    </body>
</html>
<?php

require_once('./connection/connectionString.php');

if(isset($_POST['submit'])) {
    // Get the event details from the form
    $venueName = $_POST['venueName'];
    $venueAddress = $_POST['venueAddress'];
    $venuePostalCode = $_POST['venuePostalCode'];
    $venueImg = $_POST['venueImg'];

    $stmt = $conn->prepare("INSERT INTO venue (venueName, venueAddress, venuePostalCode, venueImg) VALUES (:venueName, :venueAddress, :venuePostalCode, :venueImg)");
    $stmt->bindParam(':venueName', $venueName);
    $stmt->bindParam(':venueAddress', $venueAddress);
    $stmt->bindParam(':venuePostalCode', $venuePostalCode);
    $stmt->bindParam(':venueImg', $venueImg);
    $stmt->execute();

    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Venue</title>
</head>
<body>
    <h1>Create Venue</h1>
    <form method="post">
        <label>Venue Name:</label>
        <input type="text" name="venueName" required>
        <label>Venue Address:</label>
        <input type="text" name="venueAddress" required>
        <label>Venue Postal Code:</label>
        <input type="text" name="venuePostalCode" required>
        <label>Venue Image URL:</label>
        <input type="text" name="venueImg" required>
        <input type="submit" name="submit" value="Create Venue">
        </form>
    </body>
</html>
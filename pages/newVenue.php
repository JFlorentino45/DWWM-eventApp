<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');

$role = strip_tags(htmlspecialchars(AccountInfo::getRole()));

if ($role == 'admin' || $role == 'organiser') {
    if (isset($_POST['submit'])) {
        $venueName = strip_tags(htmlspecialchars($_POST['venueName']));
        $venueAddress = strip_tags(htmlspecialchars($_POST['venueAddress']));
        $venuePostalCode = strip_tags(htmlspecialchars($_POST['venuePostalCode']));
        $venueImg = strip_tags(htmlspecialchars($_POST['venueImg']));
        $stmt = $conn->prepare(
            "CALL newVenueCreate(:venueName, :venueAddress, :venuePostalCode, :venueImg)");
        $stmt->bindParam(':venueName', $venueName);
        $stmt->bindParam(':venueAddress', $venueAddress);
        $stmt->bindParam(':venuePostalCode', $venuePostalCode);
        $stmt->bindParam(':venueImg', $venueImg);
        $stmt->execute();

        header('Location: index.php');
        exit();
    }
} else {
    header("Location: " . TEMPLATE . '403.php');
}

?>

<main>
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
</main>
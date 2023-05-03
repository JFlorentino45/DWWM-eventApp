<?php
require_once('./connection/connectionString.php');
require_once('./classes/AccountInfo.php');
require_once('./classes/CheckVID.php');

$role = strip_tags(htmlspecialchars(AccountInfo::getRole()));
$venueID = strip_tags(htmlspecialchars($_GET['id']));
CheckVID::GetvID($venueID, $conn);

if ($role == 'admin') {
    $stmt = $conn->prepare("SELECT * FROM venue WHERE venueID = :id");
    $stmt->bindParam('id', $venueID);
    $stmt->execute();
    $venue = $stmt->fetch();

    if (isset($_POST['submit'])) {
        // Get the event details from the form
        $venueName = strip_tags($_POST['venueName']);
        $venueAddress = strip_tags($_POST['venueAddress']);
        $venuePostalCode = strip_tags($_POST['venuePostalCode']);
        $venueImg = strip_tags($_POST['venueImg']);

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
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare('CALL editVDelete(:venueID)');
        $stmt->bindParam(':venueID', $venueID);
        $stmt->execute();

        header('Location: index.php?page=venues');
        exit();
    }
} else {
    header("Location: " . TEMPLATE . '403.php');
}
?>

<main>
    <h1>Edit Venue</h1>
    <form method="post" onsubmit='return confirm("Are you sure?")'>
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
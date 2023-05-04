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
    <form method="post" class="form" onsubmit='return confirm("Are you sure?")'>
        <div class="title">Edit Venue</div>
        <div class="input-container ic1">
            <input id="venueName" name="venueName" class="input" type="text" value="<?php echo htmlspecialchars($venue['venueName']); ?>" required />
            <div class="cut"></div>
            <label for="venueName" class="placeholder">Name*</label>
        </div>
        <div class="input-container ic2">
            <input id="venueAddress" name="venueAddress" class="input" type="text" value='<?php echo htmlspecialchars($venue['venueAddress']) ?>' required />
            <div class="cut"></div>
            <label for="venueAddress" class="placeholder">Address*</label>
        </div>
        <div class="input-container ic2">
            <input id="venuePostalCode" name="venuePostalCode" class="input" type="text" value='<?php echo htmlspecialchars($venue['venuePostalCode']) ?>' required />
            <div class="cut"></div>
            <label for="venuePostalCode" class="placeholder">Postal Code*</label>
        </div>
        <div class="input-container ic2">
            <input id="venueImg" name="venueImg" class="input" type="text" value='<?php echo htmlspecialchars($venue['venueImg']) ?>' required />
            <div class="cut"></div>
            <label for="venueImg" class="placeholder">Image URL*</label>
        </div>
        <input type="submit" name="submit" class='submit' value="Edit Venue">
        <input type="submit" name="delete" class='submitR' value="Delete Venue">
    </form>
</main>
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
    <form class='form' method="post">
        <div class='title'>Create Venue</div>
        <div class="input-container ic1">
            <input id="venueName" name="venueName" class="input" type="text" placeholder=" " required />
            <div class="cut"></div>
            <label for="venueName" class="placeholder">Name*</label>
        </div>
        <div class="input-container ic2">
            <input id="venueAddress" name="venueAddress" class="input" type="text" placeholder=" " required />
            <div class="cut"></div>
            <label for="venueAddress" class="placeholder">Address*</label>
        </div>
        <div class="input-container ic2">
            <input id="venuePostalCode" name="venuePostalCode" class="input" type="text" placeholder=" " required />
            <div class="cut"></div>
            <label for="venuePostalCode" class="placeholder">Postal Code*</label>
        </div>
        <div class="input-container ic2">
            <input id="venueImg" name="venueImg" class="input" type="text" placeholder=" " required />
            <div class="cut"></div>
            <label for="venueImg" class="placeholder">Image URL*</label>
        </div>
        <button type="submit" name="submit" class="submit">Create</button>
    </form>
</main>
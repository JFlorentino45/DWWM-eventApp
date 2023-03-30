
<?php
    include('./connection/connectionString.php');
    $stmt = $conn->prepare("SELECT * FROM event");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(isset($_POST['clickme'])) {
        header('Location: index.php?page=event');
    }
?>
<div>
    <?php
foreach ($events as $event) {
    ?>
    <div class="event">
        <img class="eventImg" src="<?php echo $event['imageURL']; ?>" alt="<?php echo $event['eventName']; ?>">
        <ul class="eventInfo">
            <li>
                <h2><?php echo $event['eventName']; ?></h2>
            </li>
            <li>
                <p class="date">Date: <?php echo $event['eventDate']; ?></p>
            </li>
            <li>
                <a href="index.php?page=event">
                <form method="post">
        <input type="hidden" name="eventID" value="<?php echo $event['eventID']; ?>">
        <button type="submit" name="clickme">More Info</button>
    </form>
                </a>
            </li>
        </ul>
    </div>
    <?php
}
if (isset($_POST['eventID'])) {
    $_SESSION['eventID'] = $_POST['eventID'];
}
?>
</div>
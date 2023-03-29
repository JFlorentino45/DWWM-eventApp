<?php
// Include database connection file
include('../connection/connectionString.php');

// Check if the form has been submitted
if(isset($_POST['submit'])) {
    // Get the event details from the form
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $venueID = $_POST['venueID'];
    $description = $_POST['description'];
    $eventOrganiser = $_POST['eventOrganiser'];
    $totalSeats = $_POST['totalSeats'];
    $imageURL = $_POST['imageURL'];

    // Get the user ID from the session
    session_start();
    $userID = $_SESSION['userID'];

    // Insert the event details into the events table
    $stmt = $conn->prepare("INSERT INTO event (userID, eventName, eventDate, venueID, description, eventOrganiser, totalSeats, imageURL) VALUES (:userID, :eventName, :eventDate, :venueID, :description, :eventOrganiser, :totalSeats, :imageURL)");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':eventName', $eventName);
    $stmt->bindParam(':eventDate', $eventDate);
    $stmt->bindParam(':venueID', $venueID);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':eventOrganiser', $eventOrganiser);
    $stmt->bindParam(':totalSeats', $totalSeats);
    $stmt->bindParam(':imageURL', $imageURL);
    $stmt->execute();

    header('Location: home.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create event</title>
</head>
<body>
    <h1>Create Event</h1>
    <form method="post">
        <label>Event Name:</label>
        <input type="text" name="eventName" required>
        <label>Event Date:</label>
        <input type="datetime-local" name="eventDate" required>
        <label>Venue ID:</label>
        <input type="number" name="venueID" required>
        <label>Description:</label>
        <textarea name="description" rows="5" cols="33" required></textarea>
        <label>Event Organiser:</label>
        <input type="text" name="eventOrganiser" required>
        <label>Total Seats:</label>
        <input type="number" name="totalSeats" required>
        <label>Image Url:</label>
        <input type="text" name="imageURL" required>
        <input type="submit" name="submit" value="Create Event">
    </form>
</body>
</html>


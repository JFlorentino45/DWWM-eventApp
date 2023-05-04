<?php

class EventLogic {
    public static function getEventDetails($eventID, $conn) {
        $stmt = $conn->prepare(
            "SELECT DISTINCT event.*, venue.*
            FROM event
            JOIN venue ON event.venueID = venue.venueID
            WHERE event.eventID = :eventID"
        );
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();
        $event = $stmt->fetch();
        return $event;
    }

    public static function getNumParticipants($eventID, $conn) {
        $stmt = $conn->prepare(
            "SELECT COUNT(*) 
            FROM participate 
            WHERE eventID = :eventID"
        );
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();
        $numParticipants = $stmt->fetchColumn();
        return $numParticipants;
    }

    public static function getAttendingStatus($eventID, $userID, $conn) {
        $stmt = $conn->prepare(
            "SELECT * 
            FROM participate 
            WHERE eventID = :eventID AND userID = :userID"
        );
        $stmt->bindParam(':eventID', $eventID);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $attending = $stmt->fetch();
        return $attending;
    }

    public static function getCountForUser($eventID, $userID, $conn) {
        $stmt = $conn->prepare(
            "SELECT COUNT(*) 
            FROM participate 
            WHERE userID = :userID AND eventID = :eventID"
        );
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public static function calculateRemainingSeats($eventID, $conn) {
        $event = self::getEventDetails($eventID, $conn);
        $numParticipants = self::getNumParticipants($eventID, $conn);
        $totalSeats = $event['totalSeats'];
        $seatsRemaining = $totalSeats - $numParticipants;
        return $seatsRemaining;
    }

    public static function addEvent($userID, $eventID, $conn) {
        $stmt = $conn->prepare('CALL eventAdd(:userID, :eventID)');
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();
    }
}

?>
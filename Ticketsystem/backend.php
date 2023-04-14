<?php
session_start();

function create_connection()
{
    $servername = "192.168.25.5";
    $username = "webserver";
    $password = "telekinese";
    $dbname = "ticketsystem.tickets";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
    return $conn;
}

function submit_ticket($id, $name, $email, $subject, $message)
{
    $conn = create_connection();
    $stmt = $conn->prepare("INSERT INTO tickets (id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id, $name, $email, $subject, $message);

    if ($stmt->execute()) {
        $_SESSION['message'] = "<p class='green-text'>Ticket erfolgreich abgesendet!</p>";
    } else {
        $_SESSION['message'] = "<p class='red-text'>Fehler beim Absenden des Tickets: " . $conn->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}

function fetch_tickets()
{
    $conn = create_connection();
    $sql = "SELECT id, name, email, subject, message FROM tickets";
    $result = $conn->query($sql);

    $tickets = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }
    }

    $conn->close();
    return $tickets;
}

?>

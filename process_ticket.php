<?php
// Verbindingsbestand
$servername = "localhost"; // of je servernaam
$username = "root";        // je gebruikersnaam
$password = "";            // je wachtwoord
$dbname = "ticket_system"; // je database naam

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Ontvang de gegevens uit het formulier
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$ticket_type = $_POST['ticket-type'];
$quantity = $_POST['quantity'];

// Bereid en voer de SQL-query uit om gegevens op te slaan
$sql = "INSERT INTO ticket_purchases (name, email, phone, ticket_type, quantity) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $name, $email, $phone, $ticket_type, $quantity);

if ($stmt->execute()) {
    echo "Ticket aankoop succesvol opgeslagen!";
} else {
    echo "Er ging iets mis: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

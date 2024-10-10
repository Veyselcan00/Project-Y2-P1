<?php
// Toon alle fouten voor debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database verbinding
$servername = "localhost"; // Verander dit indien nodig
$username = "root";        // Verander dit indien nodig
$password = "";            // Verander dit indien nodig
$dbname = "contact_form";  // De naam van je database

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Verzamel de formuliergegevens
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Bereid en bind de SQL-instructie
$stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $subject, $message);

// Voer de instructie uit
if ($stmt->execute()) {
    echo "Bericht succesvol opgeslagen!";
    
    // Stuur een bevestigingsmail naar de gebruiker
    $to = $email;
    $subject = "Bevestiging van je bericht";
    $body = "Bedankt voor je bericht, $name. We zullen binnen 24-48 uur reageren.\n\nJe bericht:\n$subject\n$message";
    $headers = "From: noreply@jouwdomein.com"; // Verander dit naar je eigen domein

    if (mail($to, $subject, $body, $headers)) {
        echo "Bevestigingsmail succesvol verzonden!";
    } else {
        echo "Fout bij het verzenden van de bevestigingsmail.";
    }
} else {
    echo "Fout: " . $stmt->error;
}

// Sluit de instructie en de verbinding
$stmt->close();
$conn->close();
?>
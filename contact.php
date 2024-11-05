<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Database connection
    $servername = "localhost"; 
    $username = "root";        
    $password = "";            
    $dbname = "contact_form";  

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }

    // Initialize messages
    $confirmationMessage = "";
    $errorMessage = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Step 1: Save contact details for event updates
        $stmt_event = $conn->prepare("INSERT INTO event_info (name, email) VALUES (?, ?)");
        $stmt_event->bind_param("ss", $name, $email);

        if ($stmt_event->execute()) {
            // Scenario 1: Successfully saved for event updates
            $confirmationMessage = "<h2 style='color: green;'>Uw contactgegevens zijn succesvol opgeslagen. U ontvangt binnenkort updates over het evenement.</h2>";
        } else {
            // Scenario 2: Error during save
            $errorMessage = "<p style='color: red;'>Er is een probleem opgetreden bij het opslaan van uw contactgegevens. Probeer het opnieuw.</p>";
        }

        // Step 2: Save message to contact form
        $stmt_message = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt_message->bind_param("ssss", $name, $email, $subject, $message);

        if (!$stmt_message->execute()) {
            $errorMessage .= "<p style='color: red;'>Fout bij het opslaan van bericht: " . $stmt_message->error . "</p>";
        }

        // Close statements and connection
        $stmt_event->close();
        $stmt_message->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNEAKERFESS - Contact Us</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=League+Gothic&display=swap">
    <link rel="stylesheet" href="style.css">
    <script>
        function limitTextInput() {
            var messageField = document.getElementById("message");
            var maxLength = 250;
            var currentLength = messageField.value.length;

            if (currentLength >= maxLength) {
                messageField.value = messageField.value.substring(0, maxLength);
            }

            document.getElementById("charCount").textContent = maxLength - currentLength + " tekens over";
        }
    </script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <ul>
        <li><a href="home.html">HOME</a></li>
        <li><a href="events.html">EVENTS</a></li>
        <li><a href="sneakerfess.html">SNEAKERFESS</a></li>
        <li><a href="tickets.html">TICKETS</a></li>
        <li><a href="faq.html">FAQ</a></li>
    </ul>
</nav>

<main>
    <h1>Contact Us</h1>
    
    <?php
        // Display confirmation or error message
        if (!empty($confirmationMessage)) {
            echo $confirmationMessage;
        }

        if (!empty($errorMessage)) {
            echo $errorMessage;
        }
    ?>

    <!-- Contact Form -->
    <form id="contactForm" action="" method="POST">
        <h1>Contact Form</h1>
        
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">E-mailadres:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="subject">Onderwerp:</label>
        <input type="text" id="subject" name="subject" required>
        
        <label for="message">Bericht:</label>
        <textarea id="message" name="message" maxlength="250" oninput="limitTextInput()" required></textarea>
        <p id="charCount">250 tekens over</p>
        
        <button type="submit">Verstuur</button>
    </form>
</main>

<br><br><br><br><br>

<!-- Footer -->
<footer>
    <div class="footer-container">
        <div class="footer-left">
            <h3>Sneaker HUB</h3>
            <p>© 2024 Sneaker HUB. All rights reserved.</p>
        </div>
        <div class="footer-center">
            <a href="events.html">Events</a>
            <a href="tickets.html">Tickets</a>
            <a href="faq.html">FAQ</a>
            <a href="contact.html">Contact</a>
        </div>
        <div class="footer-right">
            <a href="#"><img src="Facebook_Logo_2023.png" alt="Facebook"></a>
            <a href="#"><img src="1691832581twitter-x-icon-png.png" alt="Twitter"></a>
            <a href="#"><img src="Instagram-Icon.png" alt="Instagram"></a>
            <a href="#"><img src="Linkedin-png-linkedin-icon-1600.png" alt="LinkedIn"></a>
        </div>
    </div>
</footer>
</body>
</html>

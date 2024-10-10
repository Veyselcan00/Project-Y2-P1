document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Valideer de invoer (optioneel, kan uitgebreid worden)
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;

    if (name && email && subject && message) {
        // Simuleer het verzenden van het bericht naar het supportteam
        // Hier zou je een API-aanroep kunnen doen om het bericht daadwerkelijk te verzenden

        // Toon de bevestigingsmelding
        document.getElementById('confirmationMessage').style.display = 'block';

        // Reset het formulier
        document.getElementById('contactForm').reset();
    } else {
        alert('Vul alle velden in.');
    }
});
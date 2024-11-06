function handleCredentialResponse(response) {
    const data = jwt_decode(response.credential);
    document.getElementById("username").textContent = data.name;
    document.getElementById("userimage").src = data.picture;
    document.getElementById("profile").style.display = "block";
}

function signOut() {
    document.getElementById("profile").style.display = "none";
    google.accounts.id.disableAutoSelect();
}

// Functie om te controleren of het wachtwoord langer is dan 12 tekens
function checkPasswordAndRedirect() {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Controleer of het wachtwoord 12 tekens of langer is
    if (password.length >= 1) {
        // Verstuur de gebruiker naar de 'account_not_registered.html' pagina
        window.location.href = 'account_not_registered.html';
    } else {
        // Hier kun je de normale login logica plaatsen als het wachtwoord korter is dan 12
        console.log("Login succesvol!");
    }
}

window.onload = function () {
    google.accounts.id.initialize({
        client_id: "255120161695-olmr5pg28kecp7mm9tg956j3155b68ua.apps.googleusercontent.com",
        callback: handleCredentialResponse
    });
    google.accounts.id.renderButton(
        document.querySelector('.g_id_signin'), {
            theme: "outline",
            size: "large"
        }
    );

    // Voeg eventlistener toe aan login formulier
    document.getElementById("login-form").addEventListener("submit", function(event) {
        event.preventDefault();  // Voorkom dat het formulier standaard wordt verzonden
        checkPasswordAndRedirect();
    });
};

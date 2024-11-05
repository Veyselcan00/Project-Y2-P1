document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("ticket-modal");
    const btn = document.getElementById("open-modal-btn");
    const span = document.getElementsByClassName("close")[0];

    // Open het modaal wanneer de knop wordt geklikt
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Sluit het modaal wanneer de gebruiker op de sluitknop klikt
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Sluit het modaal wanneer de gebruiker ergens buiten het modaal klikt
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Formulier validatie en versturen
    const form = document.getElementById("ticket-form");
    form.addEventListener("submit", function(event) {
        // Basisvalidatie
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const phone = document.getElementById("phone").value;
        const ticketType = document.getElementById("ticket-type").value;
        const quantity = document.getElementById("quantity").value;

        if (!name || !email || !phone || !ticketType || !quantity) {
            event.preventDefault();
            alert("Vul alstublieft alle velden in.");
        }
    });
});

$(document).ready(function () {
    var jwt = getCookie("jwt");
    if (jwt != "") {
        $.post("http://localhost/projects/programmazione_web/api/autenticazione/validate_token.php", JSON.stringify({ jwt: jwt })).done(function (result) {
            if (result.message == "Accesso accordato.") {
                if (result.data.ruolo == "chef") {
                    sessionStorage.setItem("nome", result.data.nome);
                    sessionStorage.setItem("cognome", result.data.cognome);
                    sessionStorage.setItem("email", result.data.email);
                    sessionStorage.setItem("ruolo", result.data.ruolo);
                    sessionStorage.setItem("id", result.data.id_chef);
                    $("#first-item").html("Ordinazioni");
                    $("#second-item").html("Magazzino");
                    $("#first-item").addClass("read-dettagli-button");
                    $("#second-item").addClass("read-ingrediente-button");
                } else if (result.data.ruolo == "cameriere") {
                    sessionStorage.setItem("nome", result.data.nome);
                    sessionStorage.setItem("cognome", result.data.cognome);
                    sessionStorage.setItem("email", result.data.email);
                    sessionStorage.setItem("ruolo", result.data.ruolo);
                    sessionStorage.setItem("id", result.data.id_cameriere);
                    $("#first-item").html("Comande");
                    $("#second-item").html("Prenotazioni");
                    $("#first-item").addClass("read-comanda-button");
                    $("#second-item").addClass("read-prenotazione-button");
                } else if (result.data.ruolo == "fornitore") {
                    sessionStorage.setItem("id_genere", result.data.id_genere);
                    sessionStorage.setItem("nome", result.data.nome);
                    sessionStorage.setItem("email", result.data.email);
                    sessionStorage.setItem("ruolo", result.data.ruolo);
                    sessionStorage.setItem("id", result.data.id_fornitore);
                    $("#first-item").html("Ordini");
                    $("#first-item").addClass("read-ordine-button");
                } else if (result.data.ruolo == "admin") {
                    sessionStorage.setItem("nome", result.data.nome);
                    sessionStorage.setItem("cognome", result.data.cognome);
                    sessionStorage.setItem("email", result.data.email);
                    sessionStorage.setItem("ruolo", result.data.ruolo);
                    sessionStorage.setItem("id", result.data.id_admin);
                    $("#first-item").html("Utenti");
                    $("#second-item").html("Ristoranti");
                    $("#third-item").html("Ambienti");
                    $("#fourth-item").html("Tavoli");
                    $("#first-item").addClass("read-users-button");
                    $("#second-item").addClass("read-ristorante-button");
                    $("#third-item").addClass("read-ambiente-button");
                    $("#fourth-item").addClass("read-tavolo-button");
                }
                changePageTitle("Pannello di controllo: " + result.data.ruolo);
            }
        });
    } else {
        alert("Area riservata, accesso negato.");
        window.location.replace("http://localhost/projects/programmazione_web/index.html");
        return false;
    }
});

// getCookie()
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(";");
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
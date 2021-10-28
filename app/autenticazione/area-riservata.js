$(document).ready(function () {
    var ruolo = sessionStorage.getItem("ruolo");

    if (ruolo != null) {
        if (ruolo != "chef" && window.location == "http://localhost/projects/programmazione_web/chef.html") {
            alert("Area riservata.");
            window.location.href = "http://localhost/projects/programmazione_web/index.html";
            setCookie("jwt", "", 1);
            return false;
        }
        if (ruolo != "cameriere" && window.location == "http://localhost/projects/programmazione_web/cameriere.html") {
            alert("Area riservata.");
            window.location.href = "http://localhost/projects/programmazione_web/index.html";
            setCookie("jwt", "", 1);
            return false;
        }
        if (ruolo != "fornitore" && window.location == "http://localhost/projects/programmazione_web/fornitore.html") {
            alert("Area riservata.");
            window.location.href = "http://localhost/projects/programmazione_web/index.html";
            setCookie("jwt", "", 1);
            return false;
        }
        if (ruolo != "admin" && window.location == "http://localhost/projects/programmazione_web/admin.html") {
            alert("Area riservata.");
            window.location.href = "http://localhost/projects/programmazione_web/index.html";
            setCookie("jwt", "", 1);
            return false;
        }
    }
});

// function to set cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
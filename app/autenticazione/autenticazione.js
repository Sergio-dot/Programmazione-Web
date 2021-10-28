$(document).ready(function () {

    setCookie("jwt", "", 1);

    var create_login_html = `
        <div class="alert alert-danger d-none login-err" role="alert">
            Email e/o password errato/i, controlla i dati e riprova.
            <br>
        </div>
        <div class="alert alert-danger d-none login-err" role="alert">
            Verifica di aver selezionato il ruolo corrispondente a quello dell'account.
        </div>
        <div id='page-content' class="container d-flex justify-content-center h-100">
            <form id="login_form" action="#" method="post" class="m-auto text-center">
                <h3 class="mb-3">Accedi</h3>
                <label for="inputRuolo" class="d-none">Ruolo</label>
                <select name="ruolo" id="inputRuolo" class="form-control mb-1">
                    <option selected disabled>-- Seleziona ruolo --</option>
                    <option value="chef">Chef</option>
                    <option value="cameriere">Cameriere</option>
                    <option value="fornitore">Fornitore</option>
                    <option value="admin">Admin</option>
                </select>
                <label for="inputEmail" class="d-none">Email</label>
                <input type="text" name="email" id="inputEmail" class="form-control p-3 mb-1" placeholder="Email" required
                    autofocus>
                <label for="inputPassword" class="d-none">Password</label>
                <input type="password" name="password" id="inputPassword" class="form-control p-3 mb-1" placeholder="Password"
                    required>
                <button class="w-100 mt-1 btn btn-lg btn-primary" name="login_btn" type="submit">Sign in</button>
            </form>
        </div>

    `;

    $('#login-page').html(create_login_html);
    sessionStorage.clear();

    // trigger when login form is submitted
    $(document).on('submit', '#login_form', function (e) {
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/autenticazione/login_utente.php",
            type: "POST",
            contentType: 'application/json',
            data: form_data,
            success: function (result) {
                // store jwt to cookie
                setCookie("jwt", result.jwt, 1);
                redirect(result.token.data.ruolo);
            },
            error: function (xhr, resp, text) {
                displayError();
                console.log(xhr);
            }
        });
        e.preventDefault();
    });
});

// redirect user to page based on his role
function redirect(ruolo) {
    switch (ruolo) {
        case 'chef':
            window.location.href = "http://localhost/projects/programmazione_web/chef.html";
            break;
        case 'cameriere':
            window.location.href = "http://localhost/projects/programmazione_web/cameriere.html";
            break;
        case 'fornitore':
            window.location.href = "http://localhost/projects/programmazione_web/fornitore.html";
            break;
        case 'admin':
            window.location.href = "http://localhost/projects/programmazione_web/admin.html";
            break;
    }
}

// function to display error
function displayError() {
    $(".login-err").hide().slideDown(500).removeClass("d-none");
}

// function to set cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
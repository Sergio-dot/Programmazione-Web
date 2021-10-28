$(document).ready(function () {

    // show html form when "Aggiungi" button was clicked
    $(document).on("click", "#create-cameriere-btn", function () {
        getCameriereForm();
    });

    // show html form when "Aggiungi" button was clicked
    $(document).on("click", "#create-chef-btn", function () {
        getChefForm();
    });

    // show html form when "Aggiungi" button was clicked
    $(document).on("click", "#create-fornitore-btn", function () {
        getFornitoreForm();
    });

    // change page title
    changePageTitle("Crea nuovo utente");
});

function getCameriereForm() {
    $.getJSON("http://localhost/projects/programmazione_web/api/ristorante/read.php", function (data) {

        var create_cameriere_html = `
        <!-- "read users" button to show list of users -->
        <div id="read-users" class="btn btn-primary float-right read-users-button mb-2">
            <i class="fas fa-arrow-left"></i> Indietro
        </div>
    
        <!-- "create user" html form -->
        <form id="create-user-form" class="form-group" action="#" method="post" border="0">
            <table class="table table-hover table-bordered">

                <!-- Ruolo -->
                <tr>
                    <td>Account</td>
                    <td><input type="text" name="ruolo" class="form-control w-50" value="Cameriere" readonly="readonly" /></td>
                </tr>
    
                <!-- Ristorante -->
                <tr>
                    <td>Ristorante</td>
                    <td><select class="form-control w-50" name="id_ristorante">
                    `;

        $.each(data.records, function (key, val) {
            create_cameriere_html += `<option value='` + val.id_ristorante + `'>` + val.id_ristorante + ` - ` + val.nome + `</option>`;
        });

        create_cameriere_html += `</select></td></tr>`;

        create_cameriere_html += `
                <!-- Nome -->
                <tr>
                    <td>Nome</td>
                    <td><input type="text" name="nome" class="form-control w-50" required /></td>
                </tr>

                <!-- Cognome -->
                <tr>
                    <td>Cognome</td>
                    <td><input type="text" name="cognome" class="form-control w-50" required /></td>
                </tr>

                <!-- Email -->
                <tr>
                    <td>E-mail</td>
                    <td><input type="email" name="email" class="form-control w-50" required /></td>
                </tr>

                <!-- Password -->
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" class="form-control w-50" required /></td>
                </tr>

                <!-- Data di nascita -->
                <tr>
                    <td>Data di nascita</td>
                    <td><input type="date" name="data_nascita" class="form-control w-50" required /></td>
                </tr>

                <!-- Conferma modulo -->
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> &nbsp Conferma
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        `;

        // inject html to "page-content" of our app
        $("#page-content").html(create_cameriere_html);

        // change page title
        changePageTitle("Crea nuovo utente");
    });

    // will run when create user form is submitted
    $(document).on("submit", "#create-user-form", function () {

        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/utente/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // user created, go back to user list
                showUsers();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
                bootbox.alert("Questa email è gia utilizzata.");
            }
        });
        return false;
    });

}

function getChefForm() {
    $.getJSON("http://localhost/projects/programmazione_web/api/ristorante/read.php", function (data) {

        var create_chef_html = `
        <!-- "read users" button to show list of users -->
        <div id="read-users" class="btn btn-primary float-right read-users-button mb-2">
            <i class="fas fa-arrow-left"></i> Indietro
        </div>
    
        <!-- "create user" html form -->
        <form id="create-user-form" class="form-group" action="#" method="post" border="0">
            <table class="table table-hover table-bordered">

                <!-- Ruolo -->
                <tr>
                    <td>Account</td>
                    <td><input type="text" name="ruolo" class="form-control w-50" value="Chef" readonly="readonly" /></td>
                </tr>
    
                <!-- Ristorante -->
                <tr>
                    <td>Ristorante</td>
                    <td><select class="form-control w-50" name="id_ristorante">
                    `;

        $.each(data.records, function (key, val) {
            create_chef_html += `<option value='` + val.id_ristorante + `'>` + val.id_ristorante + ` - ` + val.nome + `</option>`;
        });

        create_chef_html += `</select></td></tr>`;

        create_chef_html += `
                <!-- Nome -->
                <tr>
                    <td>Nome</td>
                    <td><input type="text" name="nome" class="form-control w-50" required /></td>
                </tr>

                <!-- Cognome -->
                <tr>
                    <td>Cognome</td>
                    <td><input type="text" name="cognome" class="form-control w-50" required /></td>
                </tr>

                <!-- Email -->
                <tr>
                    <td>E-mail</td>
                    <td><input type="email" name="email" class="form-control w-50" required /></td>
                </tr>

                <!-- Password -->
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" class="form-control w-50" required /></td>
                </tr>

                <!-- Data di nascita -->
                <tr>
                    <td>Data di nascita</td>
                    <td><input type="date" name="data_nascita" class="form-control w-50" required /></td>
                </tr>

                <!-- Conferma modulo -->
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> &nbsp Conferma
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        `;

        // inject html to "page-content" of our app
        $("#page-content").html(create_chef_html);

        // change page title
        changePageTitle("Crea nuovo utente");
    });

    // will run when create user form is submitted
    $(document).on("submit", "#create-user-form", function () {
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/utente/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // user created, go back to user list
                showUsers();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
                bootbox.alert("Questa email è gia utilizzata.");
            }
        });
        return false;
    });
}

function getFornitoreForm() {
    $.getJSON("http://localhost/projects/programmazione_web/api/genere/read.php", function (data) {

        var create_fornitore_html = `
        <!-- "read users" button to show list of users -->
        <div id="read-users" class="btn btn-primary float-right read-users-button mb-2">
            <i class="fas fa-arrow-left"></i> Indietro
        </div>
    
        <!-- "create user" html form -->
        <form id="create-user-form" class="form-group" action="#" method="post" border="0">
            <table class="table table-hover table-bordered">

                <!-- Ruolo -->
                <tr>
                    <td>Account</td>
                    <td><input type="text" name="ruolo" class="form-control w-50" value="Fornitore" readonly="readonly" /></td>
                </tr>
    
                <!-- Genere -->
                <tr>
                    <td>Genere</td>
                    <td><select class="form-control w-50" name="id_genere">
                    `;

        $.each(data.records, function (key, val) {
            create_fornitore_html += `<option value='` + val.id_genere + `'>` + val.id_genere + ` - ` + val.nome + `</option>`;
        });

        create_fornitore_html += `</select></td></tr>`;

        create_fornitore_html += `
                <!-- Nome -->
                <tr>
                    <td>Nome</td>
                    <td><input type="text" name="nome" class="form-control w-50" required /></td>
                </tr>

                <!-- Email -->
                <tr>
                    <td>E-mail</td>
                    <td><input type="email" name="email" class="form-control w-50" required /></td>
                </tr>

                <!-- Password -->
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" class="form-control w-50" required /></td>
                </tr>

                <!-- Conferma modulo -->
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> &nbsp Conferma
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        `;

        // inject html to "page-content" of our app
        $("#page-content").html(create_fornitore_html);

        // change page title
        changePageTitle("Crea nuovo utente");
    });

    // will run when create user form is submitted
    $(document).on("submit", "#create-user-form", function () {
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/utente/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // user created, go back to user list
                showUsers();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
                bootbox.alert("Questa email è gia utilizzata.");
            }
        });
        return false;
    });
}
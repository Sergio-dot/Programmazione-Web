$(document).ready(function () {

    // show html form when "update product" button was clicked
    $(document).on("click", ".update-cameriere-button", function () {

        // get user id
        var id = $(this).attr("data-id");

        // read one record based on given user id
        $.getJSON("http://localhost/projects/programmazione_web/api/utente/read_one_cameriere.php?id=" + id, function (data) {
            // value will be used to fill out the form
            var id_ristorante = data.id_ristorante;
            var nome = data.nome;
            var cognome = data.cognome;
            var email = data.email;
            var data_nascita = data.data_nascita;

            // load list of restaurants
            $.getJSON("http://localhost/projects/programmazione_web/api/ristorante/read.php", function (data) {
                // build 'restaurant options' in html
                var ristorante_options_html = `
                    <select name="id_ristorante" class="form-control">
                `;
                // loop through returned list of data
                $.each(data.records, function (key, val) {
                    ristorante_options_html += `<option value='` + val.id_ristorante + `'>` + val.id_ristorante + ` - ` + val.nome + `</option>`;
                });
                ristorante_options_html += `</select>`;

                var update_utente_html = `
                    <!-- "read users" button to show list of users -->
                    <div id="read-users" class="btn btn-primary float-right read-users-button mb-2">
                        <i class="fas fa-arrow-left"></i> Indietro
                    </div>

                    <!-- build 'update utente' html form -->
                    <form id="update-cameriere-form" action="#" method="post" border="0">
                        <table class="table table-hover table-responsive table-bordered">
                            <!-- Ristorante -->
                            <tr>
                                <td>Ristorante</td>
                                <td>`+ ristorante_options_html + `</td>
                            </tr>
                            
                            <!-- Nome -->
                            <tr>
                                <td>Nome</td>
                                <td><input value=\"` + nome + `\" type="text" name="nome" class="form-control" required /></td>
                            </tr>
                            
                            <!-- Cognome -->
                            <tr>
                                <td>Cognome</td>
                                <td><input value=\"` + cognome + `\" type="text" name="cognome" class="form-control" required /></td>
                            </tr>
                            
                            <!-- Email -->
                            <tr>
                                <td>Email</td>
                                <td><input value=\"` + email + `\" type="text" name="email" class="form-control" required /></td>
                            </tr>
                            
                            <!-- Data di nascita -->
                            <tr>
                                <td>Data di nascita</td>
                                <td><input value=\"` + data_nascita + `\" type="text" name="data_nascita" class="form-control" required /></td>
                            </tr>

                            <tr>
                                <!-- hidden 'user id' to identify which record to delete -->
                                <td><input value=\"` + id + `\" name="id_cameriere" type="hidden" /></td>

                                <!-- button to submit form -->
                                <td>
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-check"></i> &nbsp Conferma
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                `;
                // inject to 'page-content' of our app
                $("#page-content").html(update_utente_html);

                // change page title
                changePageTitle("Modifica informazioni utente");
            });

        });

    });

    // will run when form is submitted
    $(document).on("submit", "#update-cameriere-form", function () {

        // get form data
        var form_data = JSON.stringify($(this).serializeObject());

        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/utente/update.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // user updated, go back to user list
                showUsers();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });

        return false;
    });

});
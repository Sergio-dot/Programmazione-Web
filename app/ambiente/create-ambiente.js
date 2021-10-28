$(document).ready(function () {

    // show html form when 'Aggiungi' button is clicked
    $(document).on('click', '.create-ambiente-button', function () {
        // call to ristorante/read.php to create option list
        $.getJSON("http://localhost/projects/programmazione_web/api/ristorante/read.php", function (data) {

            var ristorante_options_html = `<select class="form-control w-50" name="id_ristorante">`;
            $.each(data.records, function (key, val) {
                ristorante_options_html += `<option value='` + val.id_ristorante + `'>` + val.id_ristorante + ` - ` + val.nome + `</option>`;
            });
            ristorante_options_html += `</select></td></tr>`;

            // call to tipologia/read.php to create option list
            $.getJSON("http://localhost/projects/programmazione_web/api/tipologia/read.php", function (data) {


                var tipologia_options_html = `<select class="form-control w-50" name="id_tipologia">`;
                $.each(data.records, function (key, val) {
                    tipologia_options_html += `<option value='` + val.id_tipologia + `'>` + val.id_tipologia + ` - ` + val.nome + `</option>`;
                });
                tipologia_options_html += `</select></td></tr>`;


                var create_ambiente_html = `
                    <!-- "read ristorante" button to go back -->
                    <div id="read-ristorante" class="btn btn-primary float-right read-ambiente-button mb-2">
                        <i class="fas fa-arrow-left"></i> Indietro
                    </div>

                    <!-- create ambiente html form -->
                    <form id="create-ambiente-form" class="form-group" action="#" method="post" border="0">
                        <table class="table table-hover table-bordered">

                            <!-- Nome -->
                            <tr>
                                <td>Nome</td>
                                <td><input type="text" name="nome" class="form-control w-50" required /></td>
                            </tr>

                            <!-- Ristorante -->
                            <tr>
                                <td>Ristorante</td>
                                <td>` + ristorante_options_html + `</td>
                            </tr>

                            <!-- Tipologia -->
                            <tr>
                                <td>Tipologia</td>
                                <td>` + tipologia_options_html + `</td>
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
                $("#page-content").html(create_ambiente_html);

                // change page title
                changePageTitle("Crea nuovo ambiente");
            });
        });
    });
    // will run when 'create ambiente' form is submitted
    $(document).on("submit", "#create-ambiente-form", function () {

        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/ambiente/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // ristorante created, go back to list
                showAmbiente();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
                bootbox.alert("Errore durante l'elaborazione della richiesta.");
            }
        });
        return false;
    });
});
$(document).ready(function () {

    // show html form when 'Modifica' is clicked
    $(document).on("click", ".update-prenotazione-button", function () {

        // get 'id_prenotazione'
        var id_prenotazione = $(this).attr("data-id");

        // read one record based on given ID
        $.getJSON("http://localhost/projects/programmazione_web/api/prenotazione/read_one.php?id_prenotazione=" + id_prenotazione, function (data) {

            // values will be used to fill out the form
            var id_tavolo = data.id_tavolo;
            var nome = data.nome;
            var cognome = data.cognome;
            var data_prenotazione = data.data_prenotazione;

            $.getJSON("http://localhost/projects/programmazione_web/api/tavolo/read.php", function (data) {

                var tavolo_options_html = `<select class="form-control w-50" name="id_tavolo">`;
                $.each(data.records, function (key, val) {
                    tavolo_options_html += `<option value='` + val.id_tavolo + `'>Num: ` + val.id_tavolo + ` - ` + val.nome_ambiente + ` - Posti: ` + val.posti + `</option>`;
                });
                tavolo_options_html += `</select></td></tr>`;

                var update_prenotazione_html = `
                        <!-- "read prenotazione" button to go back -->
                        <div id="read-prenotazione" class="btn btn-primary float-right read-prenotazione-button mb-2">
                            <i class="fas fa-arrow-left"></i> Indietro
                        </div>

                        <!-- build 'update prenotazione' html form -->
                        <!-- we used the 'required' html5 property to prevent empty fields -->
                        <form id='update-prenotazione-form' action='#' method='post' border='0'>
                            <table class='table table-hover table-bordered'>
                        
                                <!-- Tavolo -->
                                <tr>
                                    <td>Tavolo</td>
                                    <td>` + tavolo_options_html + `</td>
                                </tr>

                                <!-- Nome -->
                                <tr>
                                    <td>Nome</td>
                                    <td><input class="form-control w-50" type="text" name="nome" value="` + nome + `"></td>
                                </tr>

                                <!-- Cognome -->
                                <tr>
                                    <td>Cognome</td>
                                    <td><input class="form-control w-50" type="text" name="cognome" value="` + cognome + `"></td>
                                </tr>

                                <!-- Data prenotazione -->
                                <tr>
                                    <td>Data prenotazione</td>
                                    <td><input class="form-control w-50" type="datetime-local" name="data_prenotazione"></td>
                                </tr>
                        
                                <tr>
                                    <!-- hidden 'prenotazione ID' to identify which record to delete -->
                                    <td>
                                        <input value=\"` + id_prenotazione + `\" name='id_prenotazione' type='hidden' />
                                    </td>
                        
                                    <!-- button to submit form -->
                                    <td>
                                        <button type='submit' class='btn btn-primary'>
                                            <i class="fas fa-check"></i> Conferma
                                        </button>
                                    </td>
                                </tr>

                            </table>
                        </form>
            `;

                // inject to 'page-content' of our app
                $("#page-content").html(update_prenotazione_html);

                // change page title
                changePageTitle("Modifica informazioni prenotazione: " + id_prenotazione);
            });
        });
    });

    // will run if 'update prenotazione' form is submitted
    $(document).on("submit", "#update-prenotazione-form", function () {

        // get form data
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/prenotazione/update.php",
            type: "POST",
            contentType: 'application/json',
            data: form_data,
            success: function (result) {
                // product was created, go back to products list
                showPrenotazione();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });
        return false;
    });
});
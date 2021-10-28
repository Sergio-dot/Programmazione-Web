$(document).ready(function () {

    // show html form when 'Aggiungi' button is clicked
    $(document).on('click', '.create-prenotazione-button', function () {

        $.getJSON("http://localhost/projects/programmazione_web/api/tavolo/read.php", function (data) {

            var tavolo_options_html = `<select class="form-control w-50" name="id_tavolo">`;
            $.each(data.records, function (key, val) {
                tavolo_options_html += `<option value='` + val.id_tavolo + `'>Num: ` + val.id_tavolo + ` - ` + val.nome_ambiente + ` - Posti: ` + val.posti + `</option>`;
            });
            tavolo_options_html += `</select></td></tr>`;

            var create_prenotazione_html = `
                <!-- "read prenotazione" button to go back -->
                <div id="read-prenotazione" class="btn btn-primary float-right read-prenotazione-button mb-2">
                    <i class="fas fa-arrow-left"></i> Indietro
                </div>
    
                <!-- create prenotazione html form -->
                <form id="create-prenotazione-form" class="form-group" action="#" method="post" border="0">
                    <table class="table table-hover table-bordered">
    
                        <!-- Tavolo -->
                        <tr>
                            <td>Tavolo</td>
                            <td>` + tavolo_options_html + `</td>
                        </tr>
    
                        <!-- Nome -->
                        <tr>
                            <td>Nome</td>
                            <td><input class="form-control w-50" type="text" name="nome"></td>
                        </tr>

                        <!-- Cognome -->
                        <tr>
                            <td>Cognome</td>
                            <td><input class="form-control w-50" type="text" name="cognome"></td>
                        </tr>

                        <!-- Data prenotazione -->
                        <tr>
                            <td>Data prenotazione</td>
                            <td><input class="form-control w-50" type="datetime-local" name="data_prenotazione"></td>
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

            // inject html to 'page-content' of our app
            $("#page-content").html(create_prenotazione_html);

            // change page title
            changePageTitle("Crea nuovo prenotazione");

        });
    });

    $(document).on('submit', '#create-prenotazione-form', function () {
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/prenotazione/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // prenotazione created, go back to list
                showPrenotazione();
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
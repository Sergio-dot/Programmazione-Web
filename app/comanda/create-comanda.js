$(document).ready(function () {

    // show html form when 'Aggiungi' button is clicked
    $(document).on('click', '.create-comanda-button', function () {

        $.getJSON("http://localhost/projects/programmazione_web/api/tavolo/read.php", function (data) {

            var tavolo_options_html = `<select class="form-control w-50" name="id_tavolo">`;
            $.each(data.records, function (key, val) {
                tavolo_options_html += `<option value='` + val.id_tavolo + `'>Num: ` + val.id_tavolo + ` - ` + val.nome_ambiente + ` - Posti: ` + val.posti + `</option>`;
            });
            tavolo_options_html += `</select></td></tr>`;

            var create_comanda_html = `
                <!-- "read comanda" button to go back -->
                <div id="read-comanda" class="btn btn-primary float-right read-comanda-button mb-2">
                    <i class="fas fa-arrow-left"></i> Indietro
                </div>
    
                <!-- create comanda html form -->
                <form id="create-comanda-form" class="form-group" action="#" method="post" border="0">
                    <table class="table table-hover table-bordered">
    
                        <!-- Tavolo -->
                        <tr>
                            <td>Tavolo</td>
                            <td>` + tavolo_options_html + `</td>
                        </tr>

                        <!-- Menu -->
    
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
            $("#page-content").html(create_comanda_html);

            // change page title
            changePageTitle("Crea nuova comanda");
        });
    });

    $(document).on('submit', '#create-comanda-form', function () {
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/comanda/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // comanda created, go back to list
                showComanda();
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
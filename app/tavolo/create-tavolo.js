$(document).ready(function () {

    // show html form when 'Aggiungi' button is clicked
    $(document).on('click', '.create-tavolo-button', function () {
        // call to tavolo/read.php to create option list
        $.getJSON("http://localhost/projects/programmazione_web/api/ambiente/read.php", function (data) {
            var ambiente_options_html = `<select class="form-control w-50" name="id_ambiente">`;
            $.each(data.records, function (key, val) {
                if (val.id_ambiente > 1) {
                    ambiente_options_html += `<option value='` + val.id_ambiente + `'>` + val.nome + `</option>`;
                }
            });
            ambiente_options_html += `</select></td></tr>`;

            var create_tavolo_html = `
                <!-- "read tavolo" button to go back -->
                <div id="read-tavolo" class="btn btn-primary float-right read-tavolo-button mb-2">
                    <i class="fas fa-arrow-left"></i> Indietro
                </div>
    
                <!-- create tavolo html form -->
                <form id="create-tavolo-form" class="form-group" action="#" method="post" border="0">
                    <table class="table table-hover table-bordered">
    
                        <!-- Ambiente -->
                        <tr>
                            <td>Ambiente</td>
                            <td>` + ambiente_options_html + `</td>
                        </tr>
    
                        <!-- Posti -->
                        <tr>
                            <td>Posti a sedere</td>
                            <td><input class="form-control w-50" type="number" name="posti"></td>
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
            $("#page-content").html(create_tavolo_html);

            // change page title
            changePageTitle("Crea nuovo tavolo");
        });


    });
    $(document).on('submit', '#create-tavolo-form', function () {
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/tavolo/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // tavolo created, go back to list
                showTavolo();
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
$(document).ready(function () {

    // show html form when 'Modifica' button is clicked
    $(document).on("click", ".update-ristorante-button", function () {

        // get 'id_ristorante'
        var id_ristorante = $(this).attr("data-id");

        // read one record based on given ID
        $.getJSON("http://localhost/projects/programmazione_web/api/ristorante/read_one.php?id_ristorante=" + id_ristorante, function (data) {

            // values will be used to fill out the form
            var nome = data.nome;
            var telefono = data.telefono;
            var indirizzo = data.indirizzo;

            var update_ristorante_html = `
                <!-- "read ristorante" button to show list of users -->
                <div id="read-ristorante" class="btn btn-primary float-right read-ristorante-button mb-2">
                    <i class="fas fa-arrow-left"></i> Indietro
                </div>

                <!-- build 'update ristorante' html form -->
                <!-- we used the 'required' html5 property to prevent empty fields -->
                <form id='update-ristorante-form' action='#' method='post' border='0'>
                    <table class='table table-hover table-bordered'>

                        <!-- Nome -->
                        <tr>
                            <td>Nome</td>
                            <td><input value=\"` + nome + `\" type='text' name='nome' class='form-control w-50' required /></td>
                        </tr>
                
                        <!-- Telefono -->
                        <tr>
                            <td>Telefono</td>
                            <td><input value=\"` + telefono + `\" type='tel' name='telefono' class='form-control w-50' required /></td>
                        </tr>
                        
                        <!-- Indirizzo -->
                        <tr>
                            <td>Indirizzo</td>
                            <td><input value=\"` + indirizzo + `\" type='text' name='indirizzo' class='form-control w-50' required /></td>
                        </tr>
                
                        <tr>
                            <!-- hidden 'ristorante ID' to identify which record to delete -->
                            <td>
                                <input value=\"` + id_ristorante + `\" name='id_ristorante' type='hidden' />
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
            $("#page-content").html(update_ristorante_html);

            // change page title
            changePageTitle("Modifica informazioni ristorante");
        });
    });

    // will run if 'update ristorante' form is submitted
    $(document).on("submit", "#update-ristorante-form", function () {

        // get form data
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/ristorante/update.php",
            type: "POST",
            contentType: 'application/json',
            data: form_data,
            success: function (result) {
                // product was created, go back to products list
                showRistorante();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });

        return false;
    });
});
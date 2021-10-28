$(document).ready(function () {

    // show html form when 'Modifica' is clicked
    $(document).on("click", ".update-ambiente-button", function () {

        // get 'id_ambiente'
        var id_ambiente = $(this).attr("data-id");

        // read one record based on given ID
        $.getJSON("http://localhost/projects/programmazione_web/api/ambiente/read_one.php?id_ambiente=" + id_ambiente, function (data) {

            // values will be used to fill out the form
            var id_ristorante = data.id_ristorante;
            var nome_ristorante = data.nome_ristorante;
            var id_tipologia = data.id_tipologia;
            var nome_tipologia = data.nome_tipologia;
            var nome = data.nome;

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

                    var update_ambiente_html = `
                        <!-- "read ambiente" button to show list of users -->
                        <div id="read-ambiente" class="btn btn-primary float-right read-ambiente-button mb-2">
                            <i class="fas fa-arrow-left"></i> Indietro
                        </div>

                        <!-- build 'update ambiente' html form -->
                        <!-- we used the 'required' html5 property to prevent empty fields -->
                        <form id='update-ambiente-form' action='#' method='post' border='0'>
                            <table class='table table-hover table-bordered'>

                                <!-- Nome -->
                                <tr>
                                    <td>Nome</td>
                                    <td><input value=\"` + nome + `\" type='text' name='nome' class='form-control w-50' required /></td>
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
                        
                                <tr>
                                    <!-- hidden 'ristorante ID' to identify which record to delete -->
                                    <td>
                                        <input value=\"` + id_ambiente + `\" name='id_ambiente' type='hidden' />
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
                    $("#page-content").html(update_ambiente_html);

                    // change page title
                    changePageTitle("Modifica informazioni ambiente");
                });
            });
        });
    });

    // will run if 'update ambiente' form is submitted
    $(document).on("submit", "#update-ambiente-form", function () {

        // get form data
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/ambiente/update.php",
            type: "POST",
            contentType: 'application/json',
            data: form_data,
            success: function (result) {
                // product was created, go back to products list
                showAmbiente();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });

        return false;
    });
});
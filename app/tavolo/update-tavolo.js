$(document).ready(function () {

    // show html form when 'Modifica' is clicked
    $(document).on("click", ".update-tavolo-button", function () {

        // get 'id_tavolo'
        var id_tavolo = $(this).attr("data-id");

        // read one record based on given ID
        $.getJSON("http://localhost/projects/programmazione_web/api/tavolo/read_one.php?id_tavolo=" + id_tavolo, function (data) {

            // values will be used to fill out the form
            var id_ambiente = data.id_ambiente;
            var nome_ambiente = data.nome_ambiente;
            var posti = data.posti;

            // call to tavolo/read.php to create option list
            $.getJSON("http://localhost/projects/programmazione_web/api/ambiente/read.php", function (data) {

                var ambiente_options_html = `<select class="form-control w-50" name="id_ambiente">`;
                $.each(data.records, function (key, val) {
                    if (val.id_ambiente > 1) {
                        ambiente_options_html += `<option value='` + val.id_ambiente + `'>` + val.nome + `</option>`;
                    }
                });
                ambiente_options_html += `</select></td></tr>`;

                var update_tavolo_html = `
                        <!-- "read tavolo" button to go back -->
                        <div id="read-tavolo" class="btn btn-primary float-right read-tavolo-button mb-2">
                            <i class="fas fa-arrow-left"></i> Indietro
                        </div>

                        <!-- build 'update tavolo' html form -->
                        <!-- we used the 'required' html5 property to prevent empty fields -->
                        <form id='update-tavolo-form' action='#' method='post' border='0'>
                            <table class='table table-hover table-bordered'>
                        
                                <!-- Ambiente -->
                                <tr>
                                    <td>Ambiente</td>
                                    <td>` + ambiente_options_html + `</td>
                                </tr>

                                <!-- Posti -->
                                <tr>
                                    <td>Posti a sedere</td>
                                    <td><input class="form-control w-50" type="number" name="posti" value="` + posti + `"></td>
                                </tr>
                        
                                <tr>
                                    <!-- hidden 'tavolo ID' to identify which record to delete -->
                                    <td>
                                        <input value=\"` + id_tavolo + `\" name='id_tavolo' type='hidden' />
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
                $("#page-content").html(update_tavolo_html);

                // change page title
                changePageTitle("Modifica informazioni tavolo: " + id_tavolo);

            });
        });
    });

    // will run if 'update tavolo' form is submitted
    $(document).on("submit", "#update-tavolo-form", function () {

        // get form data
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/tavolo/update.php",
            type: "POST",
            contentType: 'application/json',
            data: form_data,
            success: function (result) {
                // product was created, go back to products list
                showTavolo();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });
        return false;
    });
});
$(document).ready(function () {

    // show html form when 'Modifica' is clicked
    $(document).on("click", ".update-comanda-button", function () {

        // get 'id_comanda'
        var id_comanda = $(this).attr("data-id");

        // read one record based on given ID
        $.getJSON("http://localhost/projects/programmazione_web/api/comanda/read_one.php?id_comanda=" + id_comanda, function (data) {

            $.getJSON("http://localhost/projects/programmazione_web/api/tavolo/read.php", function (data) {

                // generates table selection menu
                var tavolo_options_html = `<select class="form-control" name="id_tavolo">`;
                $.each(data.records, function (key, val) {
                    tavolo_options_html += `<option value='` + val.id_tavolo + `'>Num: ` + val.id_tavolo + ` - ` + val.nome_ambiente + ` - Posti: ` + val.posti + `</option>`;
                });
                tavolo_options_html += `</select></td></tr>`;

                $.getJSON("http://localhost/projects/programmazione_web/api/menu/read.php", function (data) {

                    // generates menu to add dishes to the order
                    var menu_table_html = ``;

                    // loop through returned list of data
                    $.each(data.records, function (key, val) {

                        // create new table row per record
                        menu_table_html += `
                            <!-- Menu -->
                            <tr>
                                <td class="d-none">` + val.id_menu + `</td>
                                <td>` + val.nome + `</td>
                                <td>€ ` + val.prezzo + `</td>
                                <td>
                                    <!-- update button -->
                                    <a class="btn btn-success add-menuItem-button"
                                        data-id_comanda="` + id_comanda + `"
                                        data-id_menu="` + val.id_menu + `">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                    });

                    var update_comanda_html = `
                        <!-- "read comanda" button to go back -->
                        <div id="read-comanda" class="btn btn-primary float-right read-comanda-button mb-2">
                            <i class="fas fa-arrow-left"></i> Indietro
                        </div>
                        
                        <!-- build 'update comanda' html form -->
                        <!-- we used the 'required' html5 property to prevent empty fields -->
                        <form id='update-comanda-form' action='#' method='post' border='0'>
                            <table class='table table-hover'>
                        
                                <!-- Tavolo -->
                                <tr>
                                    <td>Tavolo</td>
                                    <td>` + tavolo_options_html + `</td>
                                </tr>

                                <!-- Menu -->
                                <tr>
                                    <th>Nome</th>
                                    <th>Prezzo</th>
                                    <th class="text-align-center w-25">Azione</th>
                                </tr>
                        `;

                    update_comanda_html += `
                        <tr>
                            ` + menu_table_html + `
                        </tr>
                    `;

                    update_comanda_html += `
                        
                                <tr>
                                    <!-- hidden 'comanda ID' to identify which record to delete -->
                                    <td style='display: none;'>
                                        <input value=\"` + id_comanda + `\" name='id_comanda' type='hidden' />
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
                    $("#page-content").html(update_comanda_html);

                    // change page title
                    changePageTitle("Modifica informazioni comanda: " + id_comanda);
                });
            });
        });
    });

    // add a dish to an order using 'id_comanda' and 'id_menu'
    $(document).on("click", ".add-menuItem-button", function () {
        var id_comanda = $(this).attr("data-id_comanda");
        var id_menu = $(this).attr("data-id_menu");

        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/dettagli_comanda/create.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                id_comanda: id_comanda,
                id_menu: id_menu
            }),
            success: function (result) {
                // added to order, notify
                bootbox.alert("Aggiunto alla comanda");
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
                bootbox.alert("Errore durante l'inserimento, riprova.");
            }
        });
    });

    // will run if 'update comanda' form is submitted
    $(document).on("submit", "#update-comanda-form", function () {

        // get form data
        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/comanda/update.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // product was created, go back to products list
                showComanda();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
                bootbox.alert("Il tavolo inserito non esiste");
            }
        });
        return false;
    });
});
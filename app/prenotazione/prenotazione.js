$(document).ready(function () {
    $(document).on("click", ".read-prenotazione-button", function () {
        showPrenotazione();
    });
});

function showPrenotazione() {
    // makes "Tavoli" as active on the navbar
    $("#first-item").removeClass("active");
    $("#second-item").addClass("active");

    // hide jumbotron
    $(".jumbotron").addClass("d-none");

    $.getJSON("http://localhost/projects/programmazione_web/api/prenotazione/read.php", function (data) {
        var read_prenotazione_html = `
            <!-- when clicked, it will load the create form -->
            <div class="float-right mb-3">
                <button class="btn btn-success create-prenotazione-button" type="button">
                    <i class="fas fa-plus fa-sm"></i> &nbsp Aggiungi
                </button>
            </div>

            <!-- start table -->
            <table class="table table-bordered table-hover">
                <!-- table heading -->
                <tr>
                    <th>ID_Prenotazione</th>
                    <th>Num. Tavolo</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Data prenotazione</th>
                    <th class="text-align-center w-25">Azione</th>
                </tr>
        `;
        // loop through returned list of data
        $.each(data.records, function (key, val) {
            // create new table row per record
            read_prenotazione_html += `
                <tr>
                    <td>` + val.id_prenotazione + `</td>
                    <td>` + val.id_tavolo + `</td>
                    <td>` + val.nome + `</td>
                    <td>` + val.cognome + `</td>
                    <td>` + val.data_prenotazione + `</td>

                    <!-- action buttons -->
                    <td>
                        <!-- update button -->
                        <button class="btn btn-info update-prenotazione-button" data-id="` + val.id_prenotazione + `">
                            <i class="fas fa-edit"></i> &nbsp Modifica
                        </button>
                        <!-- delete button -->
                        <button class="btn btn-danger delete-prenotazione-button" data-id="` + val.id_prenotazione + `">
                            <i class="fas fa-trash-alt"></i> &nbsp Elimina
                        </button>
                    </td>
                </tr>
            `;
        });

        // end table
        read_prenotazione_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_prenotazione_html);

        // change page title
        changePageTitle("Elenco prenotazioni");
    });
}
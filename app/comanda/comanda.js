$(document).ready(function () {
    $(document).on("click", ".read-comanda-button", function () {
        showComanda();
    });
});

function showComanda() {
    // makes "Comande" as active on the navbar
    $("#first-item").addClass("active");
    $("#second-item").removeClass("active");

    // hide jumbotron
    $(".jumbotron").addClass("d-none");

    $.getJSON("http://localhost/projects/programmazione_web/api/comanda/read.php", function (data) {
        var read_comanda_html = `
            <!-- when clicked, it will load the create form -->
            <div class="float-right mb-3">
                <button class="btn btn-success create-comanda-button" type="button">
                    <i class="fas fa-plus fa-sm"></i> &nbsp Aggiungi
                </button>
            </div>

            <!-- start table -->
            <table class="table table-bordered table-hover">
                <!-- table heading -->
                <tr>
                    <th>Num. Comanda</th>
                    <th>Num. Tavolo</th>
                    <th class="text-align-center w-25">Azione</th>
                </tr>
        `;

        // loop through returned list of data
        $.each(data.records, function (key, val) {
            // create new table row per record
            read_comanda_html += `
                <tr>
                    <td>` + val.id_comanda + `</td>
                    <td>` + val.id_tavolo + `</td>

                    <!-- action buttons -->
                    <td>
                        <!-- details button -->
                        <button class="btn btn-primary dettagli-comanda-button" data-id="` + val.id_comanda + `">
                            <i class="fas fa-eye"></i> Dettagli
                        </button>
                        <!-- update button -->
                        <button class="btn btn-info update-comanda-button" data-id="` + val.id_comanda + `">
                            <i class="fas fa-edit"></i> Modifica
                        </button>
                        <!-- delete button -->
                        <button class="btn btn-danger delete-comanda-button" data-id="` + val.id_comanda + `">
                            <i class="fas fa-trash-alt"></i> Elimina
                        </button>
                    </td>
                </tr>
            `;
        });

        // end table
        read_comanda_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_comanda_html);

        // change page title
        changePageTitle("Elenco comande");
    });
}
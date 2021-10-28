$(document).ready(function () {
    $(document).on("click", ".read-ristorante-button", function () {
        showRistorante();
    });
});

function showRistorante() {

    // makes "Ristoranti" button as active on the navbar
    $("#first-item").removeClass("active");
    $("#second-item").addClass("active");
    $("#third-item").removeClass("active");
    $("#fourth-item").removeClass("active");
    $("#fifth-item").removeClass("active");

    // hide jumbotron
    $(".jumbotron").addClass("d-none");

    $.getJSON("http://localhost/projects/programmazione_web/api/ristorante/read.php", function (data) {
        var read_ristorante_html = `
            <!-- when clicked, it will load the create form -->
            <div class="float-right mb-3">
                <button class="btn btn-success create-ristorante-btn" type="button">
                    <i class="fas fa-plus fa-sm"></i> &nbsp Aggiungi
                </button>
            </div>

            <!-- start table -->
            <table class="table table-bordered table-hover">
                <!-- table heading -->
                <tr>
                    <th>ID_Ristorante</th>
                    <th>Nome</th>
                    <th>Telefono</th>
                    <th>Indirizzo</th>
                    <th class="text-align-center">Azione</th>
                </tr>
        `;
        // loop through returned list of data
        $.each(data.records, function (key, val) {
            // create new table row per record
            read_ristorante_html += `
                <tr>
                    <td>` + val.id_ristorante + `</td>
                    <td>` + val.nome + `</td>
                    <td>` + val.telefono + `</td>
                    <td>` + val.indirizzo + `</td>

                    <!-- action buttons -->
                    <td>
                        <!-- update button -->
                        <button class="btn btn-info update-ristorante-button" data-id="` + val.id_ristorante + `">
                            <i class="fas fa-edit"></i> &nbsp Modifica
                        </button>
                        <!-- delete button -->
                        <button class="btn btn-danger delete-ristorante-button" data-id="` + val.id_ristorante + `">
                            <i class="fas fa-trash-alt"></i> &nbsp Elimina
                        </button>
                    </td>
                </tr>
            `;
        });

        // end table
        read_ristorante_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_ristorante_html);

        // change page title
        changePageTitle("Elenco ristoranti");
    });

}
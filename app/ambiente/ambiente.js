$(document).ready(function () {
    $(document).on("click", ".read-ambiente-button", function () {
        showAmbiente();
    });
});

function showAmbiente() {

    // makes "Ambienti" button as active on the navbar
    $("#first-item").removeClass("active");
    $("#second-item").removeClass("active");
    $("#third-item").addClass("active");
    $("#fourth-item").removeClass("active");
    $("#fifth-item").removeClass("active");

    // hide jumbotron
    $(".jumbotron").addClass("d-none");

    $.getJSON("http://localhost/projects/programmazione_web/api/ambiente/read.php", function (data) {
        var read_ambiente_html = `
            <!-- when clicked, it will load the create form -->
            <div class="float-right mb-3">
                <button class="btn btn-success create-ambiente-button" type="button">
                    <i class="fas fa-plus fa-sm"></i> &nbsp Aggiungi
                </button>
            </div>

            <!-- start table -->
            <table class="table table-bordered table-hover">
                <!-- table heading -->
                <tr>
                    <th>ID_Ambiente</th>
                    <th>Ristorante</th>
                    <th>Nome</th>
                    <th class="text-align-center">Azione</th>
                </tr>
        `;
        // loop through returned list of data
        $.each(data.records, function (key, val) {
            // create new table row per record
            read_ambiente_html += `
                <tr>
                    <td>` + val.id_ambiente + `</td>
                    <td>` + val.nome_ristorante + `</td>
                    <td>` + val.nome + `</td>

                    <!-- action buttons -->
                    <td>
                        <!-- update button -->
                        <button class="btn btn-info update-ambiente-button" data-id="` + val.id_ambiente + `">
                            <i class="fas fa-edit"></i> &nbsp Modifica
                        </button>
                        <!-- delete button -->
                        <button class="btn btn-danger delete-ambiente-button" data-id="` + val.id_ambiente + `">
                            <i class="fas fa-trash-alt"></i> &nbsp Elimina
                        </button>
                    </td>
                </tr>
            `;
        });

        // end table
        read_ambiente_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_ambiente_html);

        // change page title
        changePageTitle("Elenco ristoranti");
    });
}
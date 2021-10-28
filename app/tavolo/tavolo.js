$(document).ready(function () {
    $(document).on("click", ".read-tavolo-button", function () {
        showTavolo();
    });
});

function showTavolo() {

    // makes "Tavoli" as active on the navbar
    $("#first-item").removeClass("active");
    $("#second-item").removeClass("active");
    $("#third-item").removeClass("active");
    $("#fourth-item").addClass("active");
    $("#fifth-item").removeClass("active");

    // hide jumbotron
    $(".jumbotron").addClass("d-none");

    $.getJSON("http://localhost/projects/programmazione_web/api/tavolo/read.php", function (data) {
        var read_tavolo_html = `
            <!-- when clicked, it will load the create form -->
            <div class="float-right mb-3">
                <button class="btn btn-success create-tavolo-button" type="button">
                    <i class="fas fa-plus fa-sm"></i> &nbsp Aggiungi
                </button>
            </div>

            <!-- start table -->
            <table class="table table-bordered table-hover">
                <!-- table heading -->
                <tr>
                    <th>Num. Tavolo</th>
                    <th>Ambiente</th>
                    <th>Posti a sedere</th>
                    <th class="text-align-center w-25">Azione</th>
                </tr>
        `;
        // loop through returned list of data
        $.each(data.records, function (key, val) {
            // create new table row per record
            read_tavolo_html += `
                <tr>
                    <td>` + val.id_tavolo + `</td>
                    <td>` + val.nome_ambiente + `</td>
                    <td>` + val.posti + `</td>

                    <!-- action buttons -->
                    <td>
                        <!-- update button -->
                        <button class="btn btn-info update-tavolo-button" data-id="` + val.id_tavolo + `">
                            <i class="fas fa-edit"></i> Modifica
                        </button>
                        <!-- delete button -->
                        <button class="btn btn-danger delete-tavolo-button" data-id="` + val.id_tavolo + `">
                            <i class="fas fa-trash-alt"></i> Elimina
                        </button>
                    </td>
                </tr>
            `;
        });

        // end table
        read_tavolo_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_tavolo_html);

        // change page title
        changePageTitle("Elenco tavoli");
    });
}
$(document).ready(function () {
    $(document).on("click", ".read-ingrediente-button", function () {
        showIngrediente();
    });
});

function showIngrediente() {
    // makes "Magazzino" as active on the navbar
    $("#first-item").removeClass("active");
    $("#second-item").addClass("active");

    // hide jumbotron
    $(".jumbotron").addClass("d-none");

    $.getJSON("http://localhost/projects/programmazione_web/api/ingrediente/read.php", function (data) {
        var read_ingrediente_html = `
            <!-- start table -->
            <table class="table table-bordered table-hover">
                <!-- table heading -->
                <tr>
                    <th>Nome</th>
                    <th>Quantità</th>
                    <th class="text-align-center w-25">Azione</th>
                </tr>
        `;

        // loop through returned list of data
        $.each(data.records, function (key, val) {

            // create new table row per record
            read_ingrediente_html += `
                <tr>
                    <td>` + val.nome + `</td>
                    <td>` + val.quantita + `</td>

                    <!-- report button -->
                    <td>
                        <button class="btn btn-warning report-button" data-id="` + val.nome + `">
                            <i class="fas fa-exclamation-circle"></i> Segnala
                        </button>
                    </td>
                </tr>
            `;
        });

        // end table
        read_ingrediente_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_ingrediente_html);

        // change page title
        changePageTitle("Elenco comande");
    });
}

$(document).on('click', '.report-button', function () {
    var id_chef = sessionStorage.getItem("id");
    var ingrediente = $(this).attr("data-id");

    $.ajax({
        url: "http://localhost/projects/programmazione_web/api/segnalazione/create.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            id_chef: id_chef,
            ingrediente: ingrediente
        }),
        success: function (result) {
            // go back to list
            showIngrediente();
        },
        error: function (xhr, resp, text) {
            // show error to console
            console.log(xhr, resp, text);
            bootbox.alert("Errore durante l'elaborazione della richiesta.");
        }
    });
    return false;
});
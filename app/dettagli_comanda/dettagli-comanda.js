$(document).ready(function () {
    $(document).on("click", ".read-dettagli-button", function () {
        showDettagli();
    });
});

function showDettagli() {
    // makes "Ordinazioni" as active on the navbar
    $("#first-item").addClass("active");
    $("#second-item").removeClass("active");

    // hide jumbotron
    $(".jumbotron").addClass("d-none");

    $.getJSON("http://localhost/projects/programmazione_web/api/dettagli_comanda/read.php", function (data) {
        var read_dettagli_html = `
            <!-- start table -->
            <table class="table table-bordered table-hover">
                <!-- table heading -->
                <tr>
                    <th>Ordinazione #</th>
                    <th>Comanda #</th>
                    <th>Tavolo #</th>
                    <th>Piatto</th>
                    <th>Stato</th>
                    <th class="text-align-center">Azione</th>
                </tr>
        `;

        // loop through returned list of data
        $.each(data.records, function (key, val) {
            if (val.stato == 0) {
                var stato = "In preparazione";
            } else if (val.stato == 1) {
                var stato = "Pronto";
            }

            // create new table row per record
            read_dettagli_html += `
                <tr>
                    <td w-25>` + val.id_det_comanda + `</td>
                    <td w-25>` + val.id_comanda + `</td>
                    <td w-25>` + val.id_tavolo + `</td>
                    <td w-25>` + val.nome + `</td>
                    <td w-25>` + stato + `</td>

                    <!-- action buttons -->
                    <td>
                        <!-- details button -->
                        <button class="btn btn-success ready-button" data-id="` + val.id_det_comanda + `">
                            <i class="far fa-check-circle"></i> Pronto
                        </button>
                    </td>
                </tr>
            `;
        });

        // end table
        read_dettagli_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_dettagli_html);

        // change page title
        changePageTitle("Elenco comande");
    });
}

// show html form when 'Aggiungi' button is clicked
$(document).on('click', '.ready-button', function () {
    var id_det_comanda = $(this).attr("data-id");

    $.ajax({
        url: "http://localhost/projects/programmazione_web/api/dettagli_comanda/ready.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({ id_det_comanda: id_det_comanda }),
        success: function (result) {
            // go back to list
            showDettagli();
        },
        error: function (xhr, resp, text) {
            // show error to console
            console.log(xhr, resp, text);
            bootbox.alert("Errore durante l'elaborazione della richiesta.");
        }
    });
    return false;
});
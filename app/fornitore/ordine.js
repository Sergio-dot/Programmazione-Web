$(document).ready(function () {
    $(document).on("click", ".read-ordine-button", function () {
        showPannello();
    });
});

function showPannello() {
    // get 'id_fornitore' from current session
    var id_fornitore = sessionStorage.getItem("id");

    // makes "Ordini" as active on the navbar
    $("#first-item").addClass("active");

    // hide jumbotron
    $(".jumbotron").addClass("d-none");

    $.getJSON("http://localhost/projects/programmazione_web/api/segnalazione/read.php", function (data) {
        var read_ordine_html = `
            <h3 class="float-left mt-3">Ordini in attesa</h3>

            <!-- start table -->
            <table class="table table-bordered table-hover">
                <!-- table heading -->
                <tr>
                    <th>Segnalazione #</th>
                    <th>ID_Chef</th>
                    <th>Ingrediente</th>
                    <th class="text-align-center w-25">Azione</th>
                </tr>
        `;
        // loop through returned list of data
        $.each(data.records, function (key, val) {
            // create new table row per record
            read_ordine_html += `
                <tr>
                    <td>` + val.id_segnalazione + `</td>
                    <td>` + val.id_chef + `</td>
                    <td>` + val.ingrediente + `</td>
                    
                    <!-- action buttons -->
                    <td>
                        <button class="btn btn-success create-ordine-button"
                            data-id_fornitore="` + id_fornitore + `"
                            data-id_segnalazione="` + val.id_segnalazione + `"
                            data-id_ingrediente="` + val.id_ingrediente + `">
                            <i class="far fa-handshake"></i>&nbspPrendi in carico
                        </button>
                    </td>
                </tr>
            `;
        });

        // end table
        read_ordine_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_ordine_html);

        // change page title
        changePageTitle("Elenco tavoli");
    });
}

$(document).on('click', '.create-ordine-button', function () {
    var id_fornitore = $(this).attr("data-id_fornitore");
    var id_segnalazione = $(this).attr("data-id_segnalazione");
    var id_ingrediente = $(this).attr("data-id_ingrediente");

    $.ajax({
        url: "http://localhost/projects/programmazione_web/api/ordine/create.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            id_fornitore: id_fornitore
        }),
        success: function (result) {
            // fill 'dettagli_ordine' table
            createDettagli(id_ingrediente, id_segnalazione);
        },
        error: function (xhr, resp, text) {
            // show error to console
            console.log(xhr, resp, text);
            bootbox.alert("Errore durante l'elaborazione della richiesta.");
        }
    });
    return false;
});

function createDettagli(id_ingrediente, id_segnalazione) {
    $.getJSON("http://localhost/projects/programmazione_web/api/ordine/read_max.php", function (data) {

        var id_ordine = data.records[0].id_ordine;

        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/dettagli_ordine/create.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                id_ordine: id_ordine,
                id_ingrediente: id_ingrediente
            }),
            success: function (result) {
                // call function to delete 'segnalazione'
                deleteSegnalazione(id_segnalazione);
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
                bootbox.alert("Errore durante l'elaborazione della richiesta");
            }
        });
        return false;
    });
}

function deleteSegnalazione(id_segnalazione) {
    $.ajax({
        url: "http://localhost/projects/programmazione_web/api/segnalazione/delete.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            id_segnalazione: id_segnalazione
        }),
        success: function (result) {
            // go back to list
            showPannello();
        },
        error: function (xhr, resp, text) {
            // show error to console
            console.log(xhr, resp, text);
        }
    });
    return false;
}
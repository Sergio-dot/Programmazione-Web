$(document).ready(function () {
    $(document).on("click", ".dettagli-comanda-button", function () {
        // get 'id_comanda'
        var id_comanda = $(this).attr("data-id");
        showDettagli(id_comanda);

        // remove a dish from an order using 'id_comanda' and 'id_menu'
        $(document).on("click", ".drop-menuItem-button", function () {
            var id_det_comanda = $(this).attr("data-id_dettagli");
            var id_comanda = $(this).attr("data-id_comanda");
            var id_menu = $(this).attr("data-id_menu");

            $.ajax({
                url: "http://localhost/projects/programmazione_web/api/dettagli_comanda/delete.php",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({
                    id_det_comanda: id_det_comanda,
                    id_comanda: id_comanda,
                    id_menu: id_menu
                }),
                success: function (result) {
                    // added to order, notify
                    showDettagli(id_comanda);
                },
                error: function (xhr, resp, text) {
                    // show error to console
                    console.log(xhr, resp, text);
                    bootbox.alert("Errore durante l'eliminazione, riprova.");
                }
            });
        });
    });
});

// show order details when 'Dettagli' is clicked
function showDettagli(id_comanda) {

    // read one record based on given ID
    $.getJSON("http://localhost/projects/programmazione_web/api/comanda/read_dettagli.php?id_comanda=" + id_comanda, function (data) {

        // values will be used to fill out the form
        var id_tavolo = data.records[0].id_tavolo;

        var dettagli_comanda_html = `
                <!-- "read comanda" button to go back -->
                <div id="read-comanda" class="btn btn-primary float-right read-comanda-button mb-2">
                    <i class="fas fa-arrow-left"></i> Indietro
                </div>
                
                <!-- we used the 'required' html5 property to prevent empty fields -->
                <form id='dettagli-comanda-form' class='w-50' action='#' method='post' border='0'>
                    <table class='table table-hover table-bordered'>

                        <!-- Comanda -->
                        <tr>
                            <td>Comanda</td>
                            <td><input class="form-control w-50" type="number" name="id_comanda" value="` + id_comanda + `" disabled></td>
                        </tr>
                    
                        <!-- Tavolo -->
                        <tr>
                            <td>Tavolo</td>
                            <td><input class="form-control w-50" type="number" name="id_tavolo" value="` + id_tavolo + `" disabled></td>
                        </tr>
                    </table>
                </form>
            `;

        dettagli_comanda_html += `
                <h3 class='float-left'>Riepilogo comanda</h3>
                <br/><br/>
                <table class='table table-hover table-bordered w-50 text-align-center'>
                    <tr>
                        <th>Nome</th>
                        <th>Prezzo</th>
                        <th>Stato</th>
                        <th>Azione</th>
                    </tr>`;

        // prints order content
        $.each(data.records, function (key, val) {

            if (val.stato == 0) {
                stato = "In preparazione";
            } else {
                stato = "Pronto";
            }

            dettagli_comanda_html += `
                    <tr>
                        <td class="d-none">` + val.id_menu + `</td>
                        <td>` + val.nome + `</td>
                        <td>€ ` + val.prezzo + `</td>
                        <td>` + stato + `</td>
                        <td>
                            <a class="btn btn-success drop-menuItem-button"
                                data-id_dettagli=` + val.id_det_comanda + `"
                                data-id_comanda="` + id_comanda + `"
                                data-id_menu="` + val.id_menu + `">
                                <i class="fas fa-minus"></i>
                            </a>
                        </td>
                    `;
        });

        dettagli_comanda_html += `
                </tr>
                </table >
                `;

        // inject to 'page-content' of our app
        $("#page-content").html(dettagli_comanda_html);

        // change page title
        changePageTitle("Dettagli comanda: " + id_comanda);
    });

}
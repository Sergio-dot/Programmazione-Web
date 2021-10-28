$(document).ready(function () {
    // show html form when "Aggiungi" button is clicked
    $(document).on("click", ".create-ristorante-btn", function () {

        var create_ristorante_html = `
            <!-- "read ristorante" button to show list of users -->
            <div id="read-ristorante" class="btn btn-primary float-right read-ristorante-button mb-2">
                <i class="fas fa-arrow-left"></i> Indietro
            </div>

            <!-- create ristorante html form -->
            <form id="create-ristorante-form" class="form-group" action="#" method="post" border="0">
                <table class="table table-hover table-bordered">
                    
                    <!-- Nome -->
                    <tr>
                        <td>Nome</td>
                        <td><input type="text" name="nome" class="form-control w-50" required /></td>
                    </tr>

                    <!-- Telefono -->
                    <tr>
                        <td>Telefono</td>
                        <td><input type="tel" name="telefono" class="form-control w-50" required /></td>
                    </tr>

                    <!-- Indirizzo -->
                    <tr>
                        <td>Indirizzo</td>
                        <td><input type="text" name="indirizzo" class="form-control w-50" required /></td>
                    </tr>

                    <!-- Conferma modulo -->
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> &nbsp Conferma
                            </button>
                        </td>
                    </tr>

                </table>
            </form>
        `;

        // inject html to "page-content" of our app
        $("#page-content").html(create_ristorante_html);

        // change page title
        changePageTitle("Crea nuovo ristorante");
    });

    // will run when create ristorante form is submitted
    $(document).on("submit", "#create-ristorante-form", function () {

        var form_data = JSON.stringify($(this).serializeObject());

        // submit form data to api
        $.ajax({
            url: "http://localhost/projects/programmazione_web/api/ristorante/create.php",
            type: "POST",
            contentType: "application/json",
            data: form_data,
            success: function (result) {
                // ristorante created, go back to list
                showRistorante();
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
                bootbox.alert("Errore durante l'elaborazione della richiesta");
            }
        });
        return false;
    });
});
$(document).ready(function () {

    $(document).on('click', '.report-button', function () {

        // get 'id_ingrediente'
        var id_ingrediente = $(this).attr("data-id");

        $.getJSON("http://localhost/projects/programmazione_web/api/ingrediente/read_one.php?id_ingrediente=" + id_ingrediente, function (data) {

            var create_segnalazione_html = `
                <!-- "read magazzino" button to go back -->
                <div id="read-magazzino" class="btn btn-primary float-right read-magazzino-button mb-2>
                    <i class="fas fa-arrow-left"></i> Indietro
                </div>

                <!-- create comanda html form -->
                <form id="create-comanda-form" class="form-group" action="#" method="post" border="0">
                    <table class="table table-hover table-bordered w-50">

                        <!-- Nome -->
                        <tr>
                            <td>Nome</td>
                            <td><input value=\"` + data.nome + `\" type='text' name='nome' class='form-control w-50' disabled /></td>
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

            // inject html to 'page-content' of our app
            $("#page-content").html(create_segnalazione_html);

            // change page title
            changePageTitle("Nuova segnalazione");

        });

    });

});
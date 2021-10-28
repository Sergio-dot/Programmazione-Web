$(document).ready(function () {
    $(document).on("click", ".read-users-button", function () {
        showUtente();
    });
});

// showUtente() method is used to show list of users
function showUtente() {

    var read_users_html;

    $(document).ready(function () {
        showCameriere();
    });

    // makes "Utenti" button as active on the navbar
    $("#first-item").addClass("active");
    $("#second-item").removeClass("active");
    $("#third-item").removeClass("active");
    $("#fourth-item").removeClass("active");
    $("#fifth-item").removeClass("active");

    // hide jumbotron
    $(".jumbotron").addClass("d-none");

    $(document).on("click", "#read-cameriere-btn", function () {
        showCameriere();
    });

    $(document).on("click", "#read-chef-btn", function () {
        showChef();
    });

    $(document).on("click", "#read-fornitore-btn", function () {
        showFornitore();
    });

    // inject to "page-content" of our app
    $("#page-content").html(read_users_html);
}

function showCameriere() {
    $.getJSON("http://localhost/projects/programmazione_web/api/utente/read_cameriere.php", function (data) {
        read_users_html = `
        <!-- when clicked, it will load the create form -->
        <div class="dropdown float-right">
            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Aggiungi
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a id="create-cameriere-btn" class="dropdown-item" href="#"><i class="fas fa-plus fa-sm"></i> &nbsp Cameriere</a>
                <a id="create-chef-btn" class="dropdown-item" href="#"><i class="fas fa-plus fa-sm"></i> &nbsp Chef</a>
                <a id="create-fornitore-btn" class="dropdown-item" href="#"><i class="fas fa-plus fa-sm"></i> &nbsp Fornitore</a>
            </div>
        </div>

        <nav aria-label="Role switch">
            <ul class="pagination">
                <li id="read-cameriere-btn" class="page-item active"><a class="page-link" href="#">Cameriere</a></li>
                <li id="read-chef-btn" class="page-item"><a class="page-link" href="#">Chef</a></li>
                <li id="read-fornitore-btn" class="page-item"><a class="page-link" href="#">Fornitore</a></li>
            </ul>
        </nav>

        <div id="page-content" class="container-fluid w-75 mt-2">
            <h1 id="panel-title"></h1>
        </div>

        <!-- start table -->
        <table class="table table-bordered table-hover">
            <!-- table heading -->
            <tr>
                <th>ID_Cameriere</th>
                <th>ID_Ristorante</th>
                <th>Ristorante</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th>Data di nascita</th>
                <th class="text-align-center">Azione</th>
            </tr>`;
        // loop through returned list of data
        $.each(data.records, function (key, val) {
            // create new table row per record
            read_users_html += `
                <tr>
                    <td>` + val.id_cameriere + `</td>
                    <td>` + val.id_ristorante + `</td>
                    <td>` + val.nome_ristorante + `</td>
                    <td>` + val.nome + `</td>
                    <td>` + val.cognome + `</td>
                    <td>` + val.email + `</td>
                    <td>` + val.data_nascita + `</td>
    
                    <!-- action buttons -->
                    <td>
                        <!-- delete button -->
                        <button class="btn btn-danger delete-user-button" data-id="` + val.id_cameriere + `">
                            <i class="fas fa-trash-alt"></i> &nbsp Elimina
                        </button>
                    </td>
                </tr>`;
        });

        // end table
        read_users_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_users_html);

        // change page title
        changePageTitle("Elenco utenti");
    });
}

function showChef() {
    $.getJSON("http://localhost/projects/programmazione_web/api/utente/read_chef.php", function (data) {
        read_users_html = `
        <!-- when clicked, it will load the create form -->
        <div class="dropdown float-right">
            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Aggiungi
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a id="create-cameriere-btn" class="dropdown-item" href="#"><i class="fas fa-plus fa-sm"></i> &nbsp Cameriere</a>
                <a id="create-chef-btn" class="dropdown-item" href="#"><i class="fas fa-plus fa-sm"></i> &nbsp Chef</a>
                <a id="create-fornitore-btn" class="dropdown-item" href="#"><i class="fas fa-plus fa-sm"></i> &nbsp Fornitore</a>
            </div>
        </div>

        <nav aria-label="Role switch">
            <ul class="pagination">
                <li id="read-cameriere-btn" class="page-item"><a class="page-link" href="#">Cameriere</a></li>
                <li id="read-chef-btn" class="page-item active"><a class="page-link" href="#">Chef</a></li>
                <li id="read-fornitore-btn" class="page-item"><a class="page-link" href="#">Fornitore</a></li>
            </ul>
        </nav>

        <!-- start table -->
        <table class="table table-bordered table-hover">
            <!-- creating our table heading -->
            <tr>
                <th>ID_Chef</th>
                <th>ID_Ristorante</th>
                <th>Ristorante</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th>Data di nascita</th>
                <th text-align-center">Azione</th>
            </tr>`;

        // loop through returned list of data
        $.each(data.records, function (key, val) {
            // creating new table row per record
            read_users_html += `
                <tr>
                    <td>` + val.id_chef + `</td>
                    <td>` + val.id_ristorante + `</td>
                    <td>` + val.nome_ristorante + `</td>
                    <td>` + val.nome + `</td>
                    <td>` + val.cognome + `</td>
                    <td>` + val.email + `</td>
                    <td>` + val.data_nascita + `</td>
    
                    <!-- "action" buttons -->
                    <td>
                        <!-- delete button -->
                        <button class="btn btn-danger delete-user-button" data-id="` + val.id_chef + `">
                            <i class="fas fa-trash-alt"></i> &nbsp Elimina
                        </button>
                    </td>
                </tr>`;
        });

        // end table
        read_users_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_users_html);

        // change page title
        changePageTitle("Elenco utenti");
    });
}

function showFornitore() {
    $.getJSON("http://localhost/projects/programmazione_web/api/utente/read_fornitore.php", function (data) {
        read_users_html = `
        <!-- when clicked, it will load the create form -->
        <div class="dropdown float-right">
            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Aggiungi
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a id="create-cameriere-btn" class="dropdown-item" href="#"><i class="fas fa-plus fa-sm"></i> &nbsp Cameriere</a>
                <a id="create-chef-btn" class="dropdown-item" href="#"><i class="fas fa-plus fa-sm"></i> &nbsp Chef</a>
                <a id="create-fornitore-btn" class="dropdown-item" href="#"><i class="fas fa-plus fa-sm"></i> &nbsp Fornitore</a>
            </div>
        </div>

        <nav aria-label="Role switch">
            <ul class="pagination">
                <li id="read-cameriere-btn" class="page-item"><a class="page-link" href="#">Cameriere</a></li>
                <li id="read-chef-btn" class="page-item"><a class="page-link" href="#">Chef</a></li>
                <li id="read-fornitore-btn" class="page-item active"><a class="page-link" href="#">Fornitore</a></li>
            </ul>
        </nav>

        <!-- start table -->
        <table class="table table-bordered table-hover">
            <!-- creating our table heading -->
            <tr>
                <th>ID_Fornitore</th>
                <th>ID_Genere</th>
                <th>Genere</th>
                <th>Nome</th>
                <th>Email</th>
                <th text-align-center">Azione</th>
            </tr>`;

        // loop through returned list of data
        $.each(data.records, function (key, val) {
            // creating new table row per record
            read_users_html += `
                <tr>
                    <td>` + val.id_fornitore + `</td>
                    <td>` + val.id_genere + `</td>
                    <td>` + val.nome_genere + `</td>
                    <td>` + val.nome + `</td>
                    <td>` + val.email + `</td>
    
                    <!-- "action" buttons -->
                    <td>
                        <!-- delete button -->
                        <button class="btn btn-danger delete-user-button" data-id="` + val.id_fornitore + `">
                            <i class="fas fa-trash-alt"></i> &nbsp Elimina
                        </button>
                    </td>
                </tr>`;
        });

        // end table
        read_users_html += `</table>`;

        // inject to "page-content" of our app
        $("#page-content").html(read_users_html);

        // change page title
        changePageTitle("Elenco utenti");
    });
}
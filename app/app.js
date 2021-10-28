$(document).ready(function () {

    // app html
    var app_html = `
    <!-- This div makes page width 75% -->
    <div id="nav-container" class="container-fluid w-75">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a id="brand" class="navbar-brand" href="#"><i class="far fa-lemon" style="color: yellow"></i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a id="first-item" class="nav-link" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <a id="second-item" class="nav-link" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <a id="third-item" class="nav-link" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <a id="fourth-item" class="nav-link" href="#"></a>
                    </li>
                </ul>
                <form id="form-logout" class="form-inline ml-auto">
                    <button class="btn btn-outline-danger" type="submit">Logout</button>
                </form>
            </div>
        </nav>
        <div class="jumbotron jumbotron-fluid mt-3">
            <h1 class="display-4">Benvenuto!</h1>
            <p class="lead">Questo è il pannello di controllo della tua area principale, puoi spostarti utilizzando la barra di navigazione in alto.</p>
            <hr class="my-4">
        </div>

        <div class='page-header'>
            <h1 id='page-title'></h1>
        </div>
        
        <!-- this is where the contents will be shown. -->
        <div id='page-content' class="container-fluid mt-2">
            <h1 id="panel-title"></h1>
        </div>
    </div>
        
        `;

    // inject to 'app' in index.html
    $("#app").html(app_html);

});

// change page title
function changePageTitle(page_title) {

    // change title tag
    document.title = page_title;

}

// function to make form values to json format
$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
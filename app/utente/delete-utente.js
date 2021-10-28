$(document).ready(function () {
    // delete function for cameriere
    $(document).on("click", ".delete-user-button", function () {
        // user id will be here
        var id_utente = $(this).attr("data-id");

        if ($("#read-cameriere-btn").hasClass("active")) {
            var ruolo = "cameriere";
        } else if ($("#read-chef-btn").hasClass("active")) {
            var ruolo = "chef";
        } else if ($("#read-fornitore-btn").hasClass("active")) {
            var ruolo = "fornitore";
        } else {
            alert("Error while role detecting");
        }

        // bootbox to show confirm pop-up
        bootbox.confirm({
            message: "<h4>Confermi di voler eliminare l'utente?</h4>",
            buttons: {
                confirm: {
                    label: '<i class="far fa-thumbs-up"></i> &nbsp Conferma',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<i class="fas fa-times"></i> &nbsp Annulla',
                    className: 'btn-primary'
                }
            },
            callback: function (result) {
                if (result == true) {
                    // send delete request to server/api
                    $.ajax({
                        url: "http://localhost/projects/programmazione_web/api/utente/delete.php",
                        type: "POST",
                        dataType: "json",
                        data: JSON.stringify({ id: id_utente, ruolo: ruolo }),
                        success: function (result) {
                            if (ruolo == "cameriere") {
                                showUsers();
                            } else if (ruolo == "chef") {
                                showChef();
                            } else {
                                showFornitore();
                            }
                        },
                        error: function (xhr, resp, text) {
                            console.log(xhr, resp, text);
                        }
                    });
                }
            }
        });
    });
});
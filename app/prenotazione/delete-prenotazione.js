$(document).ready(function () {

    // when delete action button is clicked
    $(document).on("click", ".delete-prenotazione-button", function () {
        // id_prenotazione will be here
        var id_prenotazione = $(this).attr("data-id");

        // bootbox to show confirm pop-up
        bootbox.confirm({
            message: "<h4>Confermi di voler eliminare la prenotazione selezionata?</h4>",
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
                        url: "http://localhost/projects/programmazione_web/api/prenotazione/delete.php",
                        type: "POST",
                        dataType: "json",
                        data: JSON.stringify({ id_prenotazione: id_prenotazione }),
                        success: function (result) {
                            showPrenotazione();
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
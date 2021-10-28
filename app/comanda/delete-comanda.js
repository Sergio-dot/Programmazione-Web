$(document).ready(function () {

    // when delete action button is clicked
    $(document).on("click", ".delete-comanda-button", function () {
        // id_comanda will be here
        var id_comanda = $(this).attr("data-id");

        // bootbox to show confirm pop-up
        bootbox.confirm({
            message: "<h4>Confermi di voler eliminare la comanda selezionata?</h4>",
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
                        url: "http://localhost/projects/programmazione_web/api/comanda/delete.php",
                        type: "POST",
                        dataType: "json",
                        data: JSON.stringify({ id_comanda: id_comanda }),
                        success: function (result) {
                            showComanda();
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
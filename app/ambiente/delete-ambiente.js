$(document).ready(function () {

    // when delete action button is clicked
    $(document).on("click", ".delete-ambiente-button", function () {
        // ambiente id will be here
        var id_ambiente = $(this).attr("data-id");

        // bootbox to show confirm pop-up
        bootbox.confirm({
            message: "<h4>Confermi di voler eliminare l'ambiente selezionato?</h4>",
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
                        url: "http://localhost/projects/programmazione_web/api/ambiente/delete.php",
                        type: "POST",
                        dataType: "json",
                        data: JSON.stringify({ id_ambiente: id_ambiente }),
                        success: function (result) {
                            showAmbiente();
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
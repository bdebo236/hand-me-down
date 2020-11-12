// disable price input if clicked donate book
$(document).ready(function() {
    // set to disable if donate
    $("#book-detail-form").on('click','#donate', function(e) {
        $("#price").prop('disabled', true);
    })
    // revert back to normal if clicked on sell option
    $("#book-detail-form").on('click','#sell', function(e) {
        $("#price").prop('disabled', false);
    })
})

$(document).ready(function() {
    $("#goBack").click(function() {
        window.history.back();
    })
})
$(document).ready(function() {
    document.getElementsByClassName('heading')[0].style.animation="welcomeMoveUp 1s forwards";
    document.getElementsByClassName('heading')[0].style.animationDelay="1s";
})

$(document).delay(2000).queue(function() {
    $.post("request-list.php"
    , function(data) {
        $("#result").append(data)
    })
});
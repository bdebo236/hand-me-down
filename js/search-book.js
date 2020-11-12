$(document).ready(function() {
    $('#btn-search').click(function() {
        var bookName = $('#bookName').val()
        if(bookName !== "") {
            // Add animation - move heading and search bar
            document.getElementsByClassName('search-wrap')[0].style.animation="moveUp 1s forwards";
            document.getElementsByClassName('heading')[0].style.animation="fadeAway 1s forwards";
            $(".info").show()

            console.log(bookName)
            $.ajax({
                type: "POST",
                url: '../php/search-book.php',
                data: {
                    book : bookName
                },
                success: function(data) {
                    $("#result").html(data);
                },
                error: function(){
                    console.log("The request failed");
                }
            });
        }
    });
})

$(document).ready(function() {
    $(".info").hide()
})
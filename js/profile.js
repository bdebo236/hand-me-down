$(document).ready(function() {
    $(".del-sale").on("click", function() {
        var saleId = $(this).attr('id')
        if (confirm('Are you sure you want to delete book on sale?')) {
            $.post("add-remove-books.php", {
                saleId : saleId
            }, function() {
                location.reload()
            })
        }
    })
})

$(document).ready(function() {
    $(".del-req").on("click", function() {
        var requestId = $(this).attr('id')
        if(confirm('Are you sure you want to delete requested book?')) {
            $.post("add-remove-books.php", {
                requestId : requestId
            }, function() {
                location.reload()
            })
        }
    })
})

$(document).ready(function() {
    $(".btn-chat").on("click", function() {
        var id = $(this).attr('id')
        $.post("add-remove-books.php", {
            friendId : id
        }, function() {
            window.location.href = "../php/chat-page.php?new="+id
        })
    })
})
// Hiding the button on load and then displaying whenever need arises
$(document).ready(function() {
    $('#not-found').hide()
})

// Print all results when user searches a book with the help of google books api
$(document).ready(function() {
    //$(".search-wrap").on('click', '#btn-search', function() {     // triggered when user pressed search button
    $("#btn-search").click(function() {
        var search = $("#bookName").val()
        if (search == "") {  // give alert if nothing entered
            alert("Enter a book name")
        } else {
            // Add animation - move heading and search bar
            document.getElementsByClassName('search-wrap')[0].style.animation="moveUp 1s forwards";
            document.getElementsByClassName('heading')[0].style.animation="fadeAway 1s forwards";
            document.getElementById('show-request-btn').style.animation="fadeAway 1s forwards";

            // ajax call
            $.ajax({  // call ajax to retrieve data from google books
                url: "https://www.googleapis.com/books/v1/volumes?q="+search+"&maxResults=40",
                datatype: "json",  // return type of data should be json file
                success: function(data) {
                    $('#result').empty();   // remove the previous present tags (if any)
                    $('#not-found').show()
                    // iterate through all the results
                    for (i = 0; i<data.items.length; i++) {
                        // gather all data from json
                        id = data.items[i].id
                        title=$('<p>' + data.items[i].volumeInfo.title + '</p>');  
                        author=$('<p> By: ' + data.items[i].volumeInfo.authors + '</p>');
                        img = $('<img>'); 	
                        try {  // if image is unavaible, we use a default 'image not found' image
                            url= data.items[i].volumeInfo.imageLinks.thumbnail;
                        } catch {
                            url = "images/product_image_not_found.jpg"
                        }
                        img.attr('src', url);               // attach url to img tag

                        // append all data using jQuery DOM methods
                        link = $('<a class="book-img"></a>')
                        container = $('<div></div>')

                        container.attr('id', 'book'+i)
                        container.attr('class', 'book-list')
                        link.attr('uniqueid', id)
                        container.appendTo("#result")
                        title.appendTo('#book'+i);
                        author.appendTo('#book'+i);
                        img.appendTo(link);
                        link.appendTo('#book'+i);
                    }
                },
                type: 'GET'
            })
        }
    })
})

// Insert all details of the one book selected through jQuery DOM 
$(document).ready(function() {
    $("#result").on('click','.book-img', function(e) {
        var uniqueID = $(this).attr('uniqueid')  // getting the uniqueID of the book selected
        //alert(uniqueID)
        window.location = "../php/upload-book.php?bookID="+uniqueID
    })
})

// Displaying empty input fields when book not found in list
$(document).ready(function() {
    $("#not-found-btn").click(function() {
        window.location = "../php/upload-book.php?bookID=notFound"
    })
})

$(document).ready(function() {
    $("#show-request-btn").click(function() {
        window.location = "../php/request-list-html.php"
    })
})
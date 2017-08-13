//Load posts list
$(document).ready(function() {
    //Load posts
    loadPosts('username', 'asc');

    //Set handlers for sorting columns
    $("#emailCol a").click(function(){
        loadPosts('email', 'asc');
    });

    $("#statusCol a").click(function(){
        loadPosts('status', 'asc');
    });

});

$('#addPostForm').validator({
    disable: true,
    focus: false,
    custom: {
        noempty: function($el) {
            //Get value of form element
            value = $el.val();

            //Make check only, if no processed by 'required' attribute
            //to prevent second message to be appeared
            if (value !== '') {
                if ($.trim(value) === '') {
                    return 'Поле не должно быть пустым.';
                }
            }
        }
    }
}).on('submit', function(event) {
    //Do nothing if some form checks is invalid
    if (event.isDefaultPrevented()) {
       return;
    }

    //Define helper variables
    let username = $("#inputUsername").val();
    let email = $("#inputEmail").val();
    let text = $("#inputText").val();

    //Let's submit form with ajax!
    $.ajax({
        url: "/blog/post/add",
        type: "POST",
        dataType: "json",
        data: {
            username: username,
            email: email,
            text: text
        },
        error: function(data) {
            console.log('AJAX response for "' + this.url + '" error:\n' + data.responseText);
        },
        success : function(data) {
            if (data.result == 'success') {
                id = data.id;
                addPostMedia({username, email, text, id});
                $('#addPostModal').modal('hide');
                $("#inputUsername").val('');
                $("#inputEmail").val('');
                $("#inputText").val('');
                $('html, body').stop();
            }
        }
    });

    //Prevent from scrolling
    return false;
});

//Put a post to page
function addPostMedia(post)
{
    let status;

    //Prepare status to human view
    switch (post.status) {
        case 0:
            status = "<span style='color:#d9534f;' class='glyphicon glyphicon-remove'></span>";
            break;
        case 1:
            status = "<span style='color:#5cb85c;' class='glyphicon glyphicon-ok'></span>";
            break;
    }

    //Create inside divs
    let $tr = $("<tr class='table-line'></tr>");
    let $td1 = $("<td>" + post.username + "</td>");
    let $td2 = $("<td>" + post.email + "</td>");
    let $td3 = $("<td>" + post.text + "</td>");
    let $td4 = $("<td><img src='#' alt=''></a></td>");
    let $td5 = $("<td class='statusCell'>" + status + "</span></td>");
    let $td6 = "<td><a class='glyphicon glyphicon-pencil edit-post' href='#' onclick='editPost(" + post.id + ");return false;'></a></td>";
    let $td7 = "<td><a class='glyphicon glyphicon-remove-sign remove-post' href='#' onclick='removePost(" + post.id + ");return false;'></a></td>";
    
    //Structure divs
    $tr.append($td1);
    $tr.append($td2);
    $tr.append($td3);
    $tr.append($td4);
    $tr.append($td5);
    $tr.append($td6);
    $tr.append($td7);

    //Attach ready media to container
    $('#tableHeader').after($tr);
}

function removePost(id)
{
    if (!confirm("Are you sure to remove post with id " + id + "? This action can not be undone!")) {
        return false;
    }
    $.ajax({
        url: "/blog/post/remove",
        type: "POST",
        dataType: "json",
        data: {
            id: id
        },
        error: function(data) {
            console.log('AJAX response for "' + this.url + '" error:\n' + data.responseText);
        },
        success : function(data) {
            if (data.result == 'success') {
                $('#post-id_' + id).remove();
            }
        }
    });
}

function editPost(post_id)
{
    $.ajax({
        url: "/blog/" + post_id + "/",
        type: "POST",
        dataType: "json",
        data: {
            id: post_id
        },
        error: function(data) {
            console.log('AJAX response for "' + this.url + '" error:\n' + data.responseText);
        },
        success : function(data) {
            console.log('AJAX response for "' + this.url + '" success:\n');
            if (data.result == 'success') {
                post = data.post;
                console.log(data.post);
                $('#editPostModal #inputTitle').val(post.title);
                $('#editPostModal #inputText').val(post.text);
                $('#editPostModal #inputId').val(post_id);
                $('#editPostModal').modal();
            }
        }
    });

}

$('#editPostForm').validator({
    disable: true,
    focus: false,
    custom: {
        noempty: function($el) {
            //Get value of form element
            value = $el.val();

            //Make check only, if no processed by 'required' attribute
            //to prevent second message to be appeared
            if (value !== '') {
                if ($.trim(value) === '') {
                    return 'Поле не должно быть пустым.';
                }
            }
        }
    }
}).on('submit', function(event) {
    //Do nothing if some form checks is invalid
    if (event.isDefaultPrevented()) {
       return;
    }

    //Define helper variables
    let id = $('#editPostModal #inputId').val();
    let title = $("#editPostModal #inputTitle").val();
    let text = $("#editPostModal #inputText").val();
    //alert('id: ' + id + ',title: ' + title + ',text: ' + text);

    //Let's submit form with ajax!
    $.ajax({
        url: "/blog/post/edit",
        type: "POST",
        dataType: "json",
        data: {
            id: id,
            title: title,
            text: text
        },
        error: function(data) {
            alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
        },
        success : function(data) {
            console.log('AJAX response for "' + this.url + '" success:\n');
            console.log(data);  

            if (data.result == 'success') {
                editPostMedia({title, text, id});
                $('#editPostModal').modal('hide');
                $("#inputTitle").val('');
                $("#inputText").val('');
            }
        }
    });

    //Prevent from scrolling
    return false;
});

function editPostMedia(post)
{

    post_id = "#post-id_" + post.id;
    console.log(post);
    console.log('edit post media');
    console.log(post_id);
    $(post_id + ' .postTitle').html(post.title);
    $(post_id + ' .postText').html(post.text);
}

//Sort array
function sortPostsArray(colName, sortDirection)
{
    posts.sort(function(b,a){
        let textA = a[colName].toString().toLowerCase();
        let textB = b[colName].toString().toLowerCase();

        if (textA < textB) {
            switch (sortDirection) {
                case 'asc':
                    return -1;
                    break;
                case 'desc':
                    return 1;
                    break;
                default:
                    return -1;
            }
        }
        if (textA > textB) {
            switch (sortDirection) {
                case 'asc':
                    return 1;
                    break;
                case 'desc':
                    return -1;
                    break;
                default:
                    return 1;
            }

        }

        //textA == textB
        return 0;
    });

    //Update sort mark
    setSortMark(colName, sortDirection);
}

//Load posts from server and show them on page
function loadPosts(colName, sortDirection) {
    //Remove existent lines
    $(".table-line").remove();

    //Request AJAX
    $.ajax({
        url: "/blog/posts/load/",
        type: "POST",
        dataType: "json",
        data: {
        },
        error: function(data) {
            //alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
            console.log('AJAX response for "' + this.url + '" error:\n' + data.responseText);
        },
        success : function(data) {
            console.log('AJAX response for "' + this.url + '" success.');
            if (data.result == 'success') {
                posts = data.posts;

                // Sorting
                sortPostsArray(colName, sortDirection);

                //Add post content
                $.each(posts, function(key, post) {
                    addPostMedia(post);
                });
            }
        }
    });
}

//Marking header for current sort column
function setSortMark(colName, sortDirection)
{
    //Remove previous sort mark
    $("#sortMark").remove();
    $col = $("#" + colName + "Col");

    if (sortDirection == "desc") {
        classPostfix = "down";
    } else {
        classPostfix = "up";
    }

    $col.append(" <span id='sortMark' class='glyphicon glyphicon-arrow-" + classPostfix + "'></span>");

    //Get new sort direction
    switch (sortDirection) {
        case 'asc':
            newSortDirection = 'desc';
            break;
        case 'desc':
            newSortDirection = 'asc';
            break;
        default:
            newSortDirection = 'desc';
    }

    //Remove existing handler
    $col.off("click");

    //Add new handler
    $col.click(function() {
        loadPosts(colName, newSortDirection);
    });
}

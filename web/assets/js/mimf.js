//Load posts list
$(document).ready(function() {
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

                //Sort object by datetime of creation
                posts.sort(function(b,a){
                    return new Date(b.created_at) - new Date(a.created_at);
                });
                
                //Add post content
                $.each(posts, function(key, post) {
                  addPostMedia(post);
                });
            }
        }
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

function addPostMedia(post)
{
    //Create inside divs
    let $div = $("<div class='media' id='post-id_" + post.id + "'></div>");
    let $divLeft = $("<div class='media-left'></div>");
    let $title = $("<h4><span class='postTitle'>" + post.email + "</span></h4>");
    let $divBody = $("<div class='media-body'></div>");
    let $img = $("<a href=''><img src='#' alt='' class='media-object post-image'></a>");
    let $divEdit = "<a class='glyphicon glyphicon-pencil edit-post' href='#' onclick='editPost(" + post.id + ");return false;'></a>"; 
    let $divRemove = "<a class='glyphicon glyphicon-remove-sign remove-post' href='#' onclick='removePost(" + post.id + ");return false;'></a>";
    
    //Structure divs
    $title.append($divEdit);
    $title.append($divRemove);
    $divLeft.prepend($img);
    $divBody.prepend($title);
    $divBody.append("<div class='postText'>" + post.text + "</div>");
    $div.prepend($divLeft);
    $div.append($divBody);
    
    //Attach ready media to container
    $('#postsList').prepend($div);
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
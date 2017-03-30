//Load posts list
$(document).ready(function() {
    $.ajax({
        url: "/blog/posts/load/",
        type: "POST",
        dataType: "json",
        data: {
        },
        error: function(answer) {
          alert('Ajax error!');
          console.log("Ajax error answer:");
          console.log(answer);
        },
        success : function(data) {
            console.log("AJAX response success");
            
            if (data.result == 'success') {
                posts = data.posts;
            }
            
            //Sort object by datetime of creation
            posts.sort(function(b,a){
                return new Date(b.created_at) - new Date(a.created_at);
            });
            
            //Add post content
            $.each(posts, function(key, post) {
              addPostMedia(post);
            });
        }
    });
});

$('#addPostForm').on('submit', function(e) {
    //Cancel standart form submission
    event.preventDefault();

    //$("#addPostForm").validator();

    //Define helper variables
    let title = $("#inputTitle").val();
    let text = $("#inputText").val();

    //Let's submit form with ajax!
    $.ajax({
        url: "/blog/post/add",
        type: "POST",
        dataType: "json",
        data: {
            title: title,
            text: text
        },
        error: function(data) {
          alert('AJAX response for ' + this.url + 'error:');
          console.log(data);
        },
        success : function(data) {
            if (data.result == 'success') {
                addPostMedia({title, text});
                $('#addPostModal').modal('hide');
                $("#inputTitle").val('');
                $("#inputText").val('');
            }
        }
    });
});

function addPostMedia(post)
{
    //Create inside divs
    let $div = $("<div class='media'></div>");
    let $divLeft = $("<div class='media-left'></div>");
    let $title = $("<h4>" + post.title + "</h4>");
    let $divBody = $("<div class='media-body'></div>");
    let $img = $(
        "<a href=''><img src='#' alt='' class='media-object post-image'></a>");
    //Structure divs
    $divLeft.prepend($img);
    $divBody.prepend($title);
    $divBody.append(post.text);
    $div.prepend($divLeft);
    $div.append($divBody);
    //Attach ready media to container
    $('#postsList').prepend($div);
}


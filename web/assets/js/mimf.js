//Load posts list
$(document).ready(function() {
    //Load posts
    loadPosts('username', 'asc');

    //Set handlers for sorting columns
    $("#emailCol a").click(function(){
        $("#emailCol").off();
        loadPosts('email', 'asc');
    });

    $("#statusCol a").click(function(){
        $("#statusCol").off();
        loadPosts('status', 'asc');
    });

    //Close edit modal handler
    $('#editPostModal').on('hidden.bs.modal', function () {
        closeEditModal();
    })

    //Image change event
    $('#inputImage').change(function(){
        //Prepare image for uploading, show image preview
        prepareImage(this);
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
                addPostRow({username, email, text, id});
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

//Put a post row to table
function addPostRow(post)
{
    //Form post id
    post_id = "post-id_" + post.id;

    //Prepare status to human view
    let statusHuman = statusToHuman(post.status);

    //Create inside divs
    let $tr = $("<tr class='table-line' id='" + post_id + "' onclick='editPost(" + post.id + ");return false;'></tr>");
    let $td1 = $("<td class='postUsername'>" + post.username + "</td>");
    let $td2 = $("<td class='postEmail'>" + post.email + "</td>");
    let $td3 = $("<td class='postText'>" + post.text + "</td>");
    let $td4 = $("<td><img src='#' alt=''></a></td>");
    let $td5 = $("<td class='postStatus'>" + statusHuman + "</span></td>");
    let $td6 = "<td><a class='glyphicon glyphicon-remove-sign remove-post' href='#' onclick='removePost(" + post.id + ");return false;'></a></td>";
    
    //Structure divs
    $tr.append($td1);
    $tr.append($td2);
    $tr.append($td3);
    $tr.append($td4);
    $tr.append($td5);
    $tr.append($td6);

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

//Open modal handler
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
                //Put data from server to array
                post = data.post;

                //Show data in console
                console.log(data.post);

                //Put variable to form on page
                $('#editPostModal #inputUsername').val(post.username);
                $('#editPostModal #inputEmail').val(post.email);
                $('#editPostModal #inputText').val(post.text);


                if (post.image === true) {
                    $img = $("<img id='preview'>");
                    $img.prop('src', "http://beejee/upload/" + post_id + ".png?timestamp=" + Date.now());

                    //Get DOM object from jQuery array
                    imgDOM = $img[0];

                    imgDOM.onload = function() {
                        $("#imagePreview").append($img);
                    }

                } else{
                    $("img#preview").remove();
                }

                //Define variable for checkbox
                if (post.status == 1 ) {
                    $('#editPostModal #inputStatus').prop('checked', true);
                } else {
                    $('#editPostModal #inputStatus').prop('checked', false);
                }

                //Put id value and show modal
                $('#editPostModal #inputId').val(post_id);
                $('#editPostModal').modal();
            }
        }
    });
}

//Close edit modal handler
function closeEditModal()
{
    $("img#preview").remove();
}

//Validate form field by JS
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
//Handle form submission
}).on('submit', function(event) {
    //Do nothing if some form checks is invalid
    if (event.isDefaultPrevented()) {
       return;
    }

    //Define helper variables
    let id = $('#editPostModal #inputId').val();
    let username = $("#editPostModal #inputUsername").val();
    let email = $("#editPostModal #inputEmail").val();
    let text = $("#editPostModal #inputText").val();
    let picture = $("#editPostModal #inputImage").val();

    //Get value of checkbox
    let status;
    if($("#editPostModal #inputStatus").prop('checked') === true) {
        status = 1;
    } else {
        status = 0;
    }


    if($("#inputImage").val()) {
        //Create file for uploading from existent preview
        imgDataUrl = getImageData($("img#preview"));
    } else {
        imgDataUrl = '';
    }

    //Upload image to server
    //uploadImage(imgDataUrl, $("#inputId").prop('value'));

    //Let's submit form with ajax!
    $.ajax({
        url: "/blog/post/edit",
        type: "POST",
        dataType: "json",
        data: {
            id: id,
            username: username,
            email: email,
            text: text,
            image: imgDataUrl,
            status: status
        },
        error: function(data) {
            console.log('AJAX response for "' + this.url + '" error:\n' + data.responseText);
        },
        success : function(data) {
            console.log('AJAX response for "' + this.url + '" success:\n');
            console.log(data);  

            if (data.result == 'success') {
                //Edit existing row in table on page
                editPostRow({username, email, text, picture, status, id});

                //Hide edit modal
                $('#editPostModal').modal('hide');

                //Prepare modal, clean values
                $("#inputUsername").val('');
                $("#inputEmail").val('');
                $("#inputText").val('');
                $("#inputImage").val('');
                $("#inputStatus").val('');
            }
        }
    });

    //Prevent from scrolling
    return false;
});

function editPostRow(post)
{
    //Form post id
    post_id = "#post-id_" + post.id;

    //Change the row in table
    $(post_id + ' .postUsername').html(post.username);
    $(post_id + ' .postEmail').html(post.email);
    $(post_id + ' .postText').html(post.text);
    $(post_id + ' .postPicture').html(post.picture);
    $(post_id + ' .postStatus').html(statusToHuman(post.status));
}

//Sort array
function sortPostsArray(posts, colName, sortDirection)
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
            console.log('AJAX response for "' + this.url + '" error:\n' + data.responseText);
        },
        success : function(data) {
            console.log('AJAX response for "' + this.url + '" success.');
            if (data.result == 'success') {
                posts = data.posts;

                // Sorting
                sortPostsArray(posts, colName, sortDirection);

                //Add post content
                $.each(posts, function(key, post) {
                    addPostRow(post);
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
        console.log("Handler: " + colName);
        loadPosts(colName, newSortDirection);
    });
}

//Transform status code for human viewing
function statusToHuman(status)
{
    switch (status) {
        case 0:
            return "<span style='color:#d9534f;' class='glyphicon glyphicon-remove'></span>";
            break;
        case 1:
            return "<span style='color:#5cb85c;' class='glyphicon glyphicon-ok'></span>";
            break;
    }
}

//Prepare image for uploading, show image preview
function prepareImage(input)
{
    if (input.files && input.files[0]) {
        $img = $("<img id='preview'>");

        var reader = new FileReader();

        //Prepare handle for reader finish loading the image
        reader.onload = function (e) {
            //Change src for image
            $img.attr('src', e.target.result);

            //Get DOM object from jQuery array
            imgDOM = $img[0];

            //Get real image width and height
            imgDOM.onload = function() {
                //Resize image and create preview
                createImagePreview($img, 320, 240);

            }
        }

        //Start reading the image
        reader.readAsDataURL(input.files[0]);
    }
}

//Resize image and create preview
function createImagePreview($img, maxWidth, maxHeight)
{
    //Get current image size
    width = $img.prop('width');
    height = $img.prop('height');

    //Calculate new image size
    if (width > height) {
        if (width > maxWidth) {
            height *= maxWidth / width;
            width = maxWidth;
        }
    } else {
        if (height > maxHeight) {
            width *= maxHeight / height;
            height = maxHeight;
        }
    }

    //Change image size
    $img.prop('width', width);
    $img.prop('height', height);

    //Show preview image
    $imagePreview = $("#imagePreview");
    $imagePreview.empty();
    $imagePreview.append($img);
}

//Get preview image data
function getImageData($img)
{
    //Create emty canvas
    canvas = document.createElement('canvas');

    //Change canvas size
    canvas.width = $img.prop('width');
    canvas.height = $img.prop('height');

    //Create preview from canvas
    ctx = canvas.getContext("2d");
    ctx.drawImage($img[0], 0, 0, canvas.width, canvas.height);

    //Get image data from URL and return
    return canvas.toDataURL("image/png");
}

//Upload image to server
function uploadImage(imgDataUrl, postId)
{
    $.ajax({
        url: '/blog/upload_image/',
        type: 'POST',
        dataType: "json",
        // mimeType: "multipart/form-data",
        // cache: false,
        // contentType: false,
        // processData: false,
        data: {
            base64_string: imgDataUrl
        },

        error: function(answer) {
            console.log('AJAX response for "' + this.url + '" error:\n' + answer.responseText);
        },

        success : function(answer) {
            console.log('AJAX response for "' + this.url + '" success.');
            if (answer.result == 'success') {
                // posts = data.posts;
                //console.log(answer.post);
                console.log(answer);
            }
        }
    });
}




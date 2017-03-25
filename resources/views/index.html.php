<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/assets/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="/assets/css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
         <form class="form-signin" id="loginForm">
            <h2 class="form-signin-heading">Please sign in</h2>
            <div class="alert alert-danger hidden" role="alert" id="submitAnswer">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <span id='answerText'></span>
            </div>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <div class="checkbox">
            <label>
               <input type="checkbox" value="remember-me"> Remember me
            </label>
           </div>
           <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
         </form>

    </div> <!-- /container -->    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script>
        $("#loginForm").submit(function(event){
            // cancels the form submission
            event.preventDefault();
            submitForm();
        });

        function submitForm(){
            // Initiate Variables With Form Content
            var email = $("#inputEmail").val();
            var password = $("#inputPassword").val();

            $.ajax({
                url: "/check_login/",
                type: "POST",
                dataType: "json",
                data: {
                    email: email,
                    password: password
                },
                success : function(answer){
                    if (answer.type == 'error') {
                        //Change answer message
                        $('#answerText').text(answer.text);
                        
                        //Show answer message
                        $('#submitAnswer').removeClass("hidden");
                    }
                }
            });
        }

        function formSuccess(){
            $( "#msgSubmit" ).removeClass( "hidden" );
        }
    </script>
  </body>
</html>
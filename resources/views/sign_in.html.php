<?php $this->extend('bas'
        . ''
        . 'e') ?>

<?php $this->start('body') ?>
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
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
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
                url: "/sign_in/check/",
                type: "POST",
                dataType: "json",
                data: {
                    email: email,
                    password: password
                },
                success : function(answer) {
                    switch (answer.type) {
                        case 'error':
                            $('#answerText').text('Invalid email or password');
                            $('#submitAnswer').removeClass("alert-success");
                            $('#submitAnswer').addClass("alert-danger");
                            $('#submitAnswer').removeClass("hidden");
                            break;
                        case 'success':
                            $('#answerText').text('Login success');
                            $('#submitAnswer').removeClass("alert-danger");
                            $('#submitAnswer').addClass("alert-success");
                            $('#submitAnswer').removeClass("hidden");
                            window.location.replace("/");
                            break;
                    }
                }
            });
        }
    </script>
<?php $this->stop('script') ?>

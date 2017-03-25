<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Demo</title>
    <style>
    a.test {
        font-weight: bold;
    }
    </style>    
</head>
<body>
    <a href="http://jquery.com/">jQuery</a>
    <script src="/assets/vendor/jquery/dist/jquery.js"></script>
    <script>
 
    $( document ).ready(function() {
        $( "a" ).addClass( "test" );
        $( "a" ).click(function( event ) {
            alert( "The link will no longer take you to jquery.com" );
            //$( "a" ).removeClass( "test" );
            event.preventDefault();
            $( this ).hide( "slow" );
        });
    });
 
    </script>
</body>
</html>
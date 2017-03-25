<html>
<head>
    <script src="/assets/vendor/jquery/dist/jquery.js"></script>
</head>
<body>
    <ul>
        <li>el 1</li>
        <li>el 2</li>
        <li id='evented'><a href='#'>el 3</a></li>
    </ul>
    <script>
        $( document ).ready(function() {
            //$( this ).find( "li" ).eq( 1 ).text().replace( "el 2", "el 22" );
            var thirdLink = $( this ).find( "li" ).eq( 1 );
            console.log(this);
            var linkText = thirdLink.text().replace( "el 2", "el 22" );
            thirdLink.text( linkText );
        });
    </script>
</body>
</html>

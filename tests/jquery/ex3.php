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
            console.log( "document loaded" );
            $( '#evented' ).click(function( event ) {
                alert( "i'm evented!" );
            });
            var li = $( "li:first" ).clone().appendTo( "ul" );
            li.html( "new list item!");
            $( "li:first" ).html( "i'm changed also!");
            $( "<li>my super new element!</li>" ).appendTo( "ul" );
            detached = $ ( "li:eq(2)" ).detach();
            detached.prependTo( "ul" );
            //alert( detached.html() );
            $( "a" ).attr({
                rel: "nofollow",
                href: function( idx, href ) {
                    return "/new/" + href + idx;
                }
            });
            
            console.log( $( "li" ).map( function(index, element) {
                return element.text;
            }).get() );
            
            
        });
    </script>
</body>
</html>

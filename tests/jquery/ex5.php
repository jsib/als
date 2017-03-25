<html>
<head>
    <script src="/assets/vendor/jquery/dist/jquery.js"></script>
</head>
<body>
    <ul>
        <div><span>Hello from div!</span></div>
    </ul>
    <script>
        $( "div" ).on( "click", function( event ) {
            console.log( "event object:" );
            console.dir( event );
            console.log( "this object:" );
            console.dir( this );
            console.log( "target object:" );
            console.dir( event.target );
        });
    </script>
</body>
</html>

<head>
	<title>Блог</title>
	<link rel="stylesheet" href="/style.css" type="text/css"/>
	<script src='jquery-3.2.1.min.js'></script>
	<script src='interface.js'></script>
</head>
<body>
  <div id='area_post'>
  </div>
  <script>
    $(document).ready(function() {
      post_add("First div", true);
      $("#post_add_button").click(function() {
	    post_add($("#i_p_t").val());
	  });
    });  

  </script>
</body>
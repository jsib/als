function post_add(text, add_button = false) {
  button_content = '';
  open_tag = "<div class='s_p_t'>";
  close_tag = "</div>";

  if (add_button == true) {
  	button_content =
  	  "<br/><input type='button' value='Add post' class='post_add' id='post_add_button'/>";
	open_tag = "<textarea id='i_p_t'>";
	close_tag = "</textarea>";
  } 

  content = 
    "<div class='post'>" + 
    open_tag + 
    text +
    close_tag +
    button_content +
    "</div>"


  $("#area_post").append(content);


}
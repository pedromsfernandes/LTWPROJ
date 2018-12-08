<?php

function draw_search_form(){?>
  <form method="get" id="searchform"> 
    <input type="text" name="search_text"> 
    <select name="search_type">
        <option value="stories">Stories</option>
        <option value="comments">Comments</option>
        <option value="channels">Channels</option>
    </select>
    <input type="submit" name="submit" value="Search"> 
  </form> 
<?php
}
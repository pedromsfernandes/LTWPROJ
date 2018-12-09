<?php

function draw_search_form(){?>
  <form method="get" id="searchform">
  <div class="choice-select" style="width:200px;"> 
        <select name="search_type">
            <option value="stories">Stories</option>
            <option value="comments">Comments</option>
            <option value="channels">Channels</option>
        </select>
      </div>
    <input type="text" name="search_text" placeholder="Search.."> 
    <input type="submit" name="submit" value="Search"> 
  </form> 
<?php
}
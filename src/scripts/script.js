'use strict'

let inputs = document.querySelectorAll("#sorting input")
    
if(inputs){
    inputs[0].addEventListener("click", getTopStories)
    
    inputs[1].addEventListener("click", function(){
        console.log("new")
    })
}

function getTopStories(event){
    // Send message
    let request = new XMLHttpRequest()
    request.open('get', '../actions/action_get_stories.php', true)
    request.addEventListener('load', handler)
    request.send()

    event.preventDefault()
}

function handler(event){
    let lines = JSON.parse(this.responseText)

    console.log(lines)

    if(lines.length > 0) {
        let stories = document.querySelectorAll("#stories")
        
        stories.forEach(function(data){
            data.remove()
        })

        lines.forEach(function(data){
        
        /*
            <article class="story">

            <form method="post" action="../actions/action_vote_story.php">
            <button name="upvote" type="submit"> <i class="fas fa-chevron-up"></i> </button>
            <input type="hidden" name="story_op" value="<?=$story['username']?>">
            <input type="hidden" name="story_id" value="<?=$story['story_id']?>">
            <input type="hidden" name="type" value="upvote">
            </form>

            <form method="post" action="../actions/action_vote_story.php">
            <button name="downvote" type="submit">  <i class="fas fa-chevron-down"></i> </button>
            <input type="hidden" name="story_op" value="<?=$story['username']?>">
            <input type="hidden" name="story_id" value="<?=$story['story_id']?>">
            <input type="hidden" name="type" value="downvote">
            </form>
            
            <p>Votes: <?=getStoryVotes($story['story_id']) ?></p>

            <header><h2><a href="../pages/story.php?id=<?=$story['story_id']?>"><?=$story['story_title']?></a></h2></header>
            <p><?=$story['story_text']?></p>
            <footer>Submitted by: <?=$story['username']?> on <?=$story['story_date']?> to <a href="../pages/channel.php?id=<?=$story['channel_id']?>"><?=getChannel($story['channel_id'])['channel_name']?></a></footer>
            
            </article>
        */
        })
    }

    event.preventDefault()
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}
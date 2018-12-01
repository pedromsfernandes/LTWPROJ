'use strict'

let inputs = document.querySelectorAll("#sorting input")

var session
var tags

let request = new XMLHttpRequest()
request.addEventListener('load', getSession)
request.open('get', '../actions/action_get_session.php', true)
request.send()
    
if(inputs.length != 0){
    inputs[0].addEventListener("click", getTopStories)
    
    inputs[1].addEventListener("click", function(){
        console.log("new")
    })
}

function getSession(event){
    event.preventDefault()

    session = JSON.parse(this.responseText)
}

function getTopStories(event){
    event.preventDefault()

    let request = new XMLHttpRequest()
    request.addEventListener('load', handler)
    request.open('get', '../actions/action_get_stories.php', true)
    request.send()
}

function handler(event){
    event.preventDefault()

    let newStories = JSON.parse(this.responseText)

    console.log(newStories)

    let stories = document.querySelectorAll("#list article")

    console.log(stories)

    stories.forEach(function(data){
        data.remove()
    })

    let list = document.querySelector("#list")

    newStories.forEach(function(data){
        let story = document.createElement("article")
        story.classList.add("story")

        story.innerHTML = `
        <form method="post" action="../actions/action_vote.php">
            <button name="upvote" type="submit"> <i class="fas fa-chevron-up"></i> </button>
            <input type="hidden" name="post_op" value="`+data.post_op+`">
            <input type="hidden" name="post_id" value="`+data.post_id+`">
            <input type="hidden" name="type" value="upvote">
            <input type="hidden" name="csrf" value="`+session.csrf+`">
        </form>
      
        <form method="post" action="../actions/action_vote.php">
            <button name="downvote" type="submit">  <i class="fas fa-chevron-down"></i> </button>
            <input type="hidden" name="post_op" value="`+data.post_op+`">
            <input type="hidden" name="post_id" value="`+data.post_id+`">
            <input type="hidden" name="type" value="downvote">
            <input type="hidden" name="csrf" value="`+session.csrf+`">
        </form>
        
        <p>Votes: `/*<?=getVotes($story['post_id']) ?>*/+`</p>
      
        <header><h2><a href="../pages/story.php?id=`+data.post_id+`">`+data.post_title+`</a></h2></header>
        `+
        /*<p><?=
          preg_replace("/\[([0-9a-zA-Z]*)]\(((?:https:\/\/|http:\/\/|www\.)[0-9a-zA-Z.\/?~#_=]*)\)/","<a href=\"$2\">$1</a>",$story['post_text']);
          ?></p>*/
        
        `<ul>
            `+getTags(data.post_id)+
        `</ul>

        <footer>Submitted by: `/*<?=getUserName($story['post_op'])?>*/+` on `+data.post_date+` to <a href="../pages/channel.php?id=`+data.channel_id+`">`/*<?=getChannel($story['channel_id'])['channel_name']?>*/+`</a></footer>
        `

        list.append(story)
    })
}

function getTags(story_id){
    let request = new XMLHttpRequest()
    request.addEventListener('load', tagHandler)
    request.open('post', '../actions/action_get_story_tags.php', true)
    request.send(encodeForAjax({story_id: story_id}))

    //console.log(tags)

    let string = ""
/*
    tags.forEach(function(tag){
        string += "<li>"+tag.tag_text+"</li>\n"
    })
*/
    return string
}

function tagHandler(event){
    event.preventDefault()

    tags = JSON.parse(this.responseText)
    console.log(tags)
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}
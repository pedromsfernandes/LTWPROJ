'use strict'

let inputs = document.querySelectorAll("#sorting input")

var session
var store

let request = new XMLHttpRequest()
request.addEventListener('load', getSession)
request.open('get', '../api/api_get_session.php', true)
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
    request.open('get', '../api/api_get_stories.php', true)
    request.send()
}

function handler(event){
    event.preventDefault()

    let newStories = JSON.parse(this.responseText)

    let stories = document.querySelectorAll("#list div")

    stories.forEach(function(data){
        data.remove()
    })

    let list = document.querySelector("#list")

    newStories.forEach(function(data){
        let story = document.createElement("article")
        story.classList.add("story")

        story.innerHTML = `
        <div class="titles">
        <header><a href="../pages/story.php?id=`+data.post_id+`">`+data.post_title+`</a></header>
        <ul>
        `+//getTags(data.post_id)+
        `
        </ul>
        <footer>Submitted by: `+getUserName(data.post_op)+` on `+data.post_date+` to <a href="../pages/channel.php?id=`+data.channel_id+`">`/*<?=getChannel($story['channel_id'])['channel_name']?>*/+`</a></footer>
        <div class="voteup">
        <form method="post" action="../actions/action_vote.php">
        <button name="upvote" type="submit"> <i class="fas fa-chevron-up"></i> </button>
        <input type="hidden" name="post_op" value="`+data.post_op+`>">
        <input type="hidden" name="post_id" value="`+data.post_id+`">
        <input type="hidden" name="type" value="upvote">
        <input type="hidden" name="csrf" value="`+session.csrf+`">
        </form>
        </div>
        <div class = "votedown">
        <form method="post" action="../actions/action_vote.php">
        <button name="downvote" type="submit">  <i class="fas fa-chevron-down"></i> </button>
        <input type="hidden" name="post_op" value="`+data.post_op+`">
        <input type="hidden" name="post_id" value="`+data.post_id+`">
        <input type="hidden" name="type" value="downvote">
        <input type="hidden" name="csrf" value="`+session.csrf+`">
        </form>
        </div>

        `/*<p><?=getVotes($story['post_id']) ?></p>*/+`
        </div>`

        list.append(story)
    })
}

function getUserName(story_op){
    let request = new XMLHttpRequest()
    request.addEventListener('load', receiver)
    request.open('post', '../api/api_get_story_op_username.php', false)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send(encodeForAjax({story_op: story_op}))

    return store
}

function getTags(story_id){
    let request = new XMLHttpRequest()
    request.addEventListener('load', receiver)
    request.open('post', '../api/api_get_story_tags.php', false)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send(encodeForAjax({story_id: story_id}))

    let string = ""
/*
    store.forEach(function(tag){
        string += "<li>"+tag.tag_text+"</li>\n"
    })
*/
    return string
}

function receiver(event){
    event.preventDefault()

    store = JSON.parse(this.responseText)
    console.log(store)
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}
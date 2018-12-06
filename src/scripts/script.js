'use strict'

var session
getSession()

var list = document.querySelector("#list")
let inputs = document.querySelectorAll("#sorting input")

if(list){
    var original = list.innerHTML
    inputs[0].addEventListener("click", drawTopStories)
    inputs[1].addEventListener("click", drawNewStories)
}



//---------
//functions
//---------

function drawTopStories(event){
    event.preventDefault()

    let request = new XMLHttpRequest()
    request.addEventListener('load', handler)
    request.open('get', '../api/api_get_top_stories.php', true)
    request.send()
}

function drawNewStories(event){
    event.preventDefault()

    let request = new XMLHttpRequest()
    request.addEventListener('load', handler)
    request.open('get', '../api/api_get_new_stories.php', true)
    request.send()
}

function handler(event){
    event.preventDefault()

    let newStories = JSON.parse(this.responseText)

    console.log(newStories)

    let stories = list.querySelectorAll("div")

    stories.forEach(function(data){
        data.remove()
    })

    newStories.forEach(function(data){
        let story = document.createElement("div")
        story.classList.add("titles")

        story.innerHTML = 
        `   <div class="flex-container-1">
                <div style= "order: 4" class="title">
                    <header><a href="../pages/story.php?id=`+data.post_id+`">`+data.post_title+`</a></header>
                </div>
                <div style= "order: 1" class="vote">
                    <form method="post" action="../actions/action_vote.php">
                        <button name="upvote" type="submit"> <i class="fas fa-chevron-up"></i> </button>
                        <input type="hidden" name="post_op" value="`+data.post_op+`">
                        <input type="hidden" name="post_id" value="`+data.post_id+`">
                        <input type="hidden" name="type" value="upvote">
                        <input type="hidden" name="csrf" value="`+session.csrf+`">
                    </form>
                </div>
                <div style= "order: 3" class = "vote">
                    <form method="post" action="../actions/action_vote.php">
                        <button name="downvote" type="submit">  <i class="fas fa-chevron-down"></i> </button>
                        <input type="hidden" name="post_op" value="`+data.post_op+`">
                        <input type="hidden" name="post_id" value="`+data.post_id+`">
                        <input type="hidden" name="type" value="downvote">
                        <input type="hidden" name="csrf" value="`+session.csrf+`">
                    </form>
                </div>
                <div style= "order: 2" class="vote-amount">
                    <p>`+data.num_votes+`</p>
                </div>
            </div>
            <div class="flex-container-2">
                <ul>
            `       +getTags(data.tags)+`
                </ul>
                <footer>Submitted by: `+data.user_name+` on `+data.post_date+` to <a href="../pages/channel.php?id=`+data.channel_id+`">`+data.channel+`</a></footer>
            </div>`

        list.append(story)
    })
}

function getSession(){
    let request = new XMLHttpRequest()
    request.addEventListener('load', sessionHandler)
    request.open('get', '../api/api_get_session.php', true)
    request.send()
}

function sessionHandler(event){
    event.preventDefault()

    session = JSON.parse(this.responseText)
}

function getTags(tags){
    let string = ""

    tags.forEach(function(tag){
        string += `<li><a href="search.php?search_text=%23`+tag.tag_text+`&search_type=stories&submit=Search">`+tag.tag_text+`</a></li>\n`
    })

    return string
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}
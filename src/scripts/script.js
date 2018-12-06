'use strict'

var session
getSession()

var list = document.querySelector('#list')
var data

if(list){
    let inputs = document.querySelectorAll('#sorting input')

    inputs[0].addEventListener('click', drawTopStories)
    inputs[1].addEventListener('click', drawNewStories)
}

let votes = document.querySelectorAll('div.vote')

votes.forEach(function(data){
    let button = data.querySelector('button')

    let info = data.querySelectorAll('input')
    let post_op = info[0].value
    let post_id = info[1].value
    let type = info[2].value
    let csrf = info[3].value

    button.addEventListener('click', function(event){
        event.preventDefault()

        let request = new XMLHttpRequest()
        request.open('post', '../api/api_vote.php', true)
        request.addEventListener('load', function(event){
            event.preventDefault()

            let votes = JSON.parse(this.responseText)

            if(votes == 'reject_log'){
                window.location.href = "../pages/login.php";
            } else
            if(votes != 'reject_csrf'){
                let label = data.parentElement.querySelector('div.vote-amount').querySelector('p')
                label.innerHTML = ""+votes
            }
        })
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        request.send(encodeForAjax({post_op: post_op, post_id: post_id, type: type, csrf: csrf}))
    })
})



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

    let stories = list.querySelectorAll('div')

    stories.forEach(function(data){
        data.remove()
    })

    newStories.forEach(function(data){
        let story = document.createElement('div')
        story.classList.add('titles')

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
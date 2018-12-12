'use strict'

var session
getSession()

var list = document.querySelector('#list')
var channel = document.querySelector('article.new-story')
if(channel)
    var idC = channel.querySelectorAll('input')[2].value

if(list){
    let inputs = document.querySelectorAll('#sorting input')

    inputs[0].addEventListener('click', drawTopStories)
    inputs[1].addEventListener('click', drawNewStories)
}

addVoteListeners()

let channelInfo = document.querySelector('#channelInfo')
if(channelInfo){
    let button = channelInfo.querySelector('button')

    if(button){
        let info = channelInfo.querySelectorAll('input')
        let channel_id = info[0].value

        button.addEventListener('click', function(event){
            event.preventDefault()

            let request = new XMLHttpRequest()
            request.open('post', '../api/api_subscribe.php', true)
            request.addEventListener('load', function(event){
                event.preventDefault()

                let answer = JSON.parse(this.responseText)

                if(answer == 'reject_log'){
                    window.location.href = "../pages/login.php";
                } else
                if(answer != 'reject_csrf'){
                    button.innerHTML = answer[0]

                    let label = button.parentElement.parentElement.querySelector('div.subscribers')

                    label.innerHTML = "Subscribers: " + answer[1]
                }
            })
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            request.send(encodeForAjax({csrf: session.csrf, channel_id: channel_id}))
        })
    }
}

let commentBox = document.querySelectorAll('#addComment')
commentBox.forEach(function(data){
    let inputs = data.querySelectorAll('input')
    let post_id = inputs[0].value
    let button = inputs[1]

    button.addEventListener('click', function(event){
        event.preventDefault()

        let area = data.querySelector('textarea')
        let text = area.value 

        let request = new XMLHttpRequest()
        request.open('post', '../api/api_add_comment.php', true)
        request.addEventListener('load', commentHandler)
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        request.send(encodeForAjax({cmt_text: text, post_id: post_id}))

        area.value = ""
    })
})

var x, i, j, selElmnt, a, b, c;
/*look for any elements with the class "channel-select":*/
x = document.getElementsByClassName("choice-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 0; j < selElmnt.length; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}





//---------
//functions
//---------

function commentHandler(event){
    event.preventDefault()

    let answer = JSON.parse(this.responseText)

    if(answer == 'reject_log'){
        window.location.href = "../pages/login.php";
    } else{
        let post_id = answer[0]
        let text = answer[1]
        let votes = answer[2]
        let post_op = answer[3]
        let username = answer[4]
        let date = answer[5].date
        let new_id = answer[6].post_id

        let comments = document.querySelector('#p'+post_id).querySelector('ol')

        let comment = document.createElement('article')
        comment.classList = 'parent-comment'
        comment.id = 'p' + new_id

        comment.innerHTML = `
        <div class="flex-container-1">       
            <div style= "order: 2" class="vote-amount">
                <p>`+votes+`</p>
            </div>  
            <div style= "order: 1" class="vote">
                <button name="upvote"> <i class="fas fa-chevron-up"></i> </button>
                <input type="hidden" name="post_op" value="`+post_op+`">
                <input type="hidden" name="post_id" value="`+new_id+`">
                <input type="hidden" name="type" value="upvote">
            </div>
            <div style= "order: 3" class="vote">  
                <button name="downvote">  <i class="fas fa-chevron-down"></i> </button>
                <input type="hidden" name="post_op" value="`+post_op+`">
                <input type="hidden" name="post_id" value="`+new_id+`">
                <input type="hidden" name="type" value="downvote">
            </div>
            <div style= "order: 4" class="comment-op">  
                <p>`+username+`</p>
            </div>
        </div>
        <div class = "comment-text"> 
            <p>`+text+`</p>
            <div>Submitted by: <a href="profile.php?id=`+post_op+`">`+username+`</a> on `+date+`</div>
        </div>
        <section id="addComment">
            <input type="hidden" name="post_id" value="`+new_id+`">
            <textarea placeholder="Add a comment"></textarea>
            <input type="submit" value="submit">
        </section>
        <ol>

        </ol>
        </li>
        `

        comments.prepend(comment)

        let div = document.createElement('div')
        div.innerHTML= `<button onclick="toggleCommentDisplay(p`+new_id+`)">Show/Hide</button>`

        comments.prepend(div)

        let commentBox = comment.querySelector('#addComment')
        let button = commentBox.querySelectorAll('input')[1]

        button.addEventListener('click', function(event){
            event.preventDefault()

            let area = commentBox.querySelector('textarea')
            let text = area.value 

            let request = new XMLHttpRequest()
            request.open('post', '../api/api_add_comment.php', true)
            request.addEventListener('load', commentHandler)
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            request.send(encodeForAjax({cmt_text: text, post_id: new_id}))

            area.value = ""
        })
    }
}

function addVoteListeners(){
    let votes = document.querySelectorAll('div.vote')

    votes.forEach(function(data){
        let button = data.querySelector('button')

        let info = data.querySelectorAll('input')
        let post_op = info[0].value
        let post_id = info[1].value
        let type = info[2].value

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
                if(votes != 'reject_csrf' && votes != 'reject_op'){
                    let label = data.parentElement.querySelector('div.vote-amount').querySelector('p')
                    label.innerHTML = ""+votes
                }
            })
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            request.send(encodeForAjax({post_op: post_op, post_id: post_id, type: type, csrf: session.csrf}))
        })
    })
}

function drawTopStories(event){
    event.preventDefault()

    if(channel){
        let request = new XMLHttpRequest()
        request.addEventListener('load', storyHandler)
        request.open('post', '../api/api_get_top_stories.php', true)
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        request.send(encodeForAjax({channel: idC}))
    }else{
        let request = new XMLHttpRequest()
        request.addEventListener('load', storyHandler)
        request.open('post', '../api/api_get_top_stories.php', true)
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        request.send(encodeForAjax({channel: -1}))
    }
}

function drawNewStories(event){
    event.preventDefault()

    if(channel){
        let request = new XMLHttpRequest()
        request.addEventListener('load', storyHandler)
        request.open('post', '../api/api_get_new_stories.php', true)
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        request.send(encodeForAjax({channel: idC}))
    }else{
        let request = new XMLHttpRequest()
        request.addEventListener('load', storyHandler)
        request.open('post', '../api/api_get_new_stories.php', true)
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        request.send(encodeForAjax({channel: -1}))
    }
}

function storyHandler(event){
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
                    <button name="upvote"> <i class="fas fa-chevron-up"></i> </button>
                    <input type="hidden" name="post_op" value="`+data.post_op+`">
                    <input type="hidden" name="post_id" value="`+data.post_id+`">
                    <input type="hidden" name="type" value="upvote">
                </div>
                <div style= "order: 3" class = "vote">
                    <button name="downvote">  <i class="fas fa-chevron-down"></i> </button>
                    <input type="hidden" name="post_op" value="`+data.post_op+`">
                    <input type="hidden" name="post_id" value="`+data.post_id+`">
                    <input type="hidden" name="type" value="downvote">
                </div>
                <div style= "order: 2" class="vote-amount">
                    <p>`+data.num_votes+`</p>
                </div>
            </div>
            <div class="flex-container-2">
                <ul>
                    `+drawTags(data.tags)+`
                </ul>
                <footer>Submitted by: <a href="profile.php?id=`+data.post_op+`">`+data.user_name+`</a> on `
                +data.post_date+drawChannel(data.channel_id, data.channel)+
                `<div class="num-comments">
                    <a href="../pages/story.php?id=`+data.post_id+`"><i class="fas fa-comment-dots"></i> `+data.num_comments+` Comments</a>
                </div>
                </footer>
            </div>`

        list.append(story)
    })

    addVoteListeners()
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

function drawTags(tags){
    let string = ""

    tags.forEach(function(tag){
        string += `<li><a href="search.php?search_text=%23`+tag.tag_text+`&search_type=stories&submit=Search">`+tag.tag_text+`</a></li>\n`
    })

    return string
}

function drawChannel(channel_id, channel_name){
    let string = " "

    if (!channel){
        string += `to <a href="../pages/channel.php?id=`+channel_id+`">`+channel_name+` </a>`
    }
    
    return string
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}

function toggleCommentDisplay(comment) {

    if (comment.style.display === "none") {
      comment.style.display = "block";
    } else {
      comment.style.display = "none";
    }
  }

function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);

let entityMap = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': '&quot;',
    "'": '&#39;',
    "/": '&#x2F;'
};

function escapeHtml(string) {
    return String(string).replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
    });
}

function openNav() {
    document.getElementById("mySidenav").style.width = "280px";
  }
  
  function closeNav() {
    document.getElementById("mySidenav").style.width = "0px";
  }
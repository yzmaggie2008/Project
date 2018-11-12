//get current url, then get the parameter
let urlParams = new URLSearchParams(window.location.search);
let pushpinId = urlParams.get('pushpinId');
let pushpinOwnerEmail, currentEmail;
let showLike = true;
let corkboardId = urlParams.get('corkboardId');

//get pushpin info
let viewOnepushpinURL = "../../api/Pushpin/view_pushpin.php?pushpinId="
    + pushpinId;
$.getJSON(viewOnepushpinURL, function (data) {
    pushpinOwnerEmail = data.email;
    corkboardId = data.corkboard_ID;
    let corkboardURL = "view-corkboard.html?corkboardId=" + data.corkboard_ID;
    $('#pushpin-user-name').html(data.user_name);
    $('#description').html(data.description);
    $('#corkboard-title').html('<a href="' + corkboardURL + '">' + data.title + '</a>');
    $('#pushpin-date').html(data.date);
    $('#pushpin-time').html(data.time);

    $('#pushpin-img').html('<div class="img-thumbnail" > <a href="'+ data.url +'"> <img class="img-fluid rounded mx-auto d-block" src="'
        + data.url
        + '" alt="The URL of pushpin\'s img doesn\'t work"> </a> </div>');
    // $('#site').html(data.site);
    $('#pushpin-domain').html(data.site);
    // $('#corkboard_ID').html(data.corkboard_ID);
    if(data.is_current_user == 1) {
        $("#follow-btn").hide();
    }
});

//get tag list
let tagListURL = "../../api/Pushpin/tag_list.php?pushpinId=" + pushpinId;
$.getJSON(tagListURL, function (data) {
    let tag="";
    if (data.message) {
        let noTags = "<span>No Tags.</span>"
        $('#tags').html(noTags);
    } else {
        $.each(data, function (k, v) {
            tag += '<span>' + v.tags + '  </span>';
        })
        $('#tags').html(tag);
    }
});

//get current user name
let sessionURL = "../../api/LogIn/get_session_info.php";
$.getJSON(sessionURL, function (data) {
   currentEmail = data.email;
});


//get like list
let likeListURL = "../../api/Pushpin/like_list.php?pushpinId=" + pushpinId;
$.getJSON(likeListURL, function (data) {
    let tag="";
    if (data.message) {
        let noLikes = "<span></span>"
        $('#like-name').html(noLikes);
    } else {
        $.each(data, function (k, v) {
            tag += '<span>&nbsp&nbsp  <strong>' + v.like_name + '</strong>&nbsp&nbsp  </span>';

            if(v.email == currentEmail) {
                showLike = false;
                console.log("showLike should be fase" + showLike);
                // $('#like').html('<button id="unlike-btn" class="btn btn-outline-primary">UnLike!</button>');
            }

            console.log(currentEmail);
            console.log(pushpinOwnerEmail);
        })
        $('#like-name').html(tag);
    }
});

//hide/show like/unlike button function
function toggleLikeButton(showLike) {
    if (showLike == true) {
        $("#unlike-btn").hide();
        $("#like-btn").show();
    } else {
        $("#like-btn").hide();
        $("#unlike-btn").show();
    }
}

//show or hide like/unlike button after ajax stop
$(document).ajaxStop(function () {
    toggleLikeButton(showLike);
    //hide the like button if current user is the owner of the pushpin
    if(pushpinOwnerEmail == currentEmail) {
        $('#like').hide();
    }
});

//add current user to like list when user click like button
$("#like-btn").click(function(){
    $.post("../../api/Pushpin/add_like.php",
        {
            userEmail: currentEmail,
            pushpinId: pushpinId
        }
        );

    //refresh to hide like button, and current username on likelist
    location.reload();
});

//handle unlike button
$("#unlike-btn").click(function(){
    $.post("../../api/Pushpin/delete_like.php",
        {
            userEmail: currentEmail,
            pushpinId: pushpinId
        }
    );

    //refresh to hide like button, and current username on likelist
    location.reload();
});

function hideOwnerFollowButton() {
    if(currentEmail == pushpinOwnerEmail) {
        $('.follow').hide();
    }
}

//hide the follow button if current user owned the corkboard
$(document).ajaxStop(function () {
    console.log( "ready!" );
    hideOwnerFollowButton();
});


//handle follow button
$(".follow-btn").click(function(){
    $.post("../../api/Pushpin/follow.php",
        {
            userEmail: currentEmail,
            ownerEmail: pushpinOwnerEmail
        }
    );

    $('.follow').html('<button class="btn btn-secondary">Followed</button>');
});

//get followed info, disable follow button if followed
let followedURL = "../../api/Pushpin/followed.php?corkboardId=" + corkboardId;
$.getJSON(followedURL, function (data) {
    if(data.followed == true) {
        $('.follow').html('<button class="btn btn-secondary">Followed</button>');
    }
});

//get current url, then get the parameter
let urlParams = new URLSearchParams(window.location.search);
let currentEmail, corkboardOwnerEmail
let followed, watched
const corkboardId = urlParams.get('corkboardId');
//get corkboard info
let viewOneCorkboardURL = "../../api/Corkboard/view_one_corkboard.php?corkboardId=" + corkboardId;
$.getJSON(viewOneCorkboardURL, function (data) {
    $('#corkboard-user-name').html(data.user_name);
    $('#corkboard-title').html(data.title);
    $('#corkboard-date').html(data.date);
    $('#corkboard-time').html(data.time);
    $('#corkboard-category').html(data.category);
    $('#corkboard-watch-num').html(data.num);
    currentEmail = data.currentEmail;
    corkboardOwnerEmail = data.ownerEmail;
    if(data.is_current_user == 1) {
        $("#follow-btn").hide();
    }
});

//get image
let viewCorkboardImgURL = "../../api/Corkboard/view_corkboard_img.php?corkboardId=" + corkboardId;
$.getJSON(viewCorkboardImgURL, function (data) {
    if(data.message) {
        let noPushpin = "<p>No Pushpins.</p>"
        $('#corkboard-img').html(noPushpin);
    } else {
        var corkboardImg = "";

        // window.console&&console.log("hello");
        $.each(data, function (k, v) {
            let pushpinURL = "view-pushpin.html?corkboardId=" + corkboardId + "&pushpinId=" + v.pushpinID;

            corkboardImg +=
            '<div class="col-6"> <div class="img-thumbnail" > <a href="' + pushpinURL + '"> <img class="img-fluid rounded mx-auto d-block" src="'
                + v.url
                + '" alt="The URL of pushpin\'s img doesn\'t work"> </a> </div></div>';
        })
        $('#corkboard-img').html(corkboardImg);
    }

});

//handle follow button
$(".follow-btn").click(function(){
    $.post("../../api/Pushpin/follow.php",
        {
            userEmail: currentEmail,
            ownerEmail: corkboardOwnerEmail
        }
    );
    console.log(currentEmail);
    console.log(corkboardOwnerEmail);

    $('.follow').html('<button class="btn btn-secondary">Followed</button>');
});

function hideOwnerFollowButton() {
    // console.log(currentEmail);
    // console.log(corkboardOwnerEmail);
    if(currentEmail == corkboardOwnerEmail) {
        // $('.follow').hide();
        $(".follow").hide();
    }
}
console.log(currentEmail);
console.log(corkboardOwnerEmail);
//hide the follow button if current user owned the corkboard
$(document).ajaxStop(function () {
    hideOwnerFollowButton();
});


$("#watch-btn").click(function(){
    $.post("../../api/Corkboard/watch.php",
        {
            userEmail: currentEmail,
            corkboardId: corkboardId
        }
    );
    $('#watch').html('<button class="btn btn-secondary">Watched</button>');
});

//get watech info
let fwedURL = "../../api/Corkboard/watched.php?corkboardId=" + corkboardId;
$.getJSON(fwedURL, function (data) {
    console.log("watched" + data.watched);
    if(data.watched == true) {
        $('#watch').html('<button class="btn btn-secondary">Watched</button>');
    }
});

//get followed info
// console.log("ownerEmail" + corkboardOwnerEmail);
let followedURL = "../../api/Pushpin/followed.php?corkboardId=" + corkboardId;
$.getJSON(followedURL, function (data) {
    if(data.followed == true) {
        $('.follow').html('<button class="btn btn-secondary">Followed</button>');
    }
});

//get corkboard private info
let isPrivateURL = "../../api/Corkboard/isPrivate.php?corkboardId=" + corkboardId;
$.getJSON(isPrivateURL, function (data) {
    if(data.isPrivate == true) {
        $('#watch-area').html('<p>This is a <strong>private</strong> Corkboard, unable to watch.</p>');
    }
});

// let addPushpinURL="add-pushpin-form.html?corkboardId=" + corkboardId;
$('#add-pushpin-btn').click(function() {
    window.location.href = "add-pushpin-form.html?corkboardId=" + corkboardId;
});

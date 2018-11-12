let urlParams = new URLSearchParams(window.location.search);
const corkboardId = urlParams.get('corkboardId');

//get corkboard info
let viewOneCorkboardURL = "../../api/Corkboard/view_one_corkboard.php?corkboardId=" + corkboardId;
$.getJSON(viewOneCorkboardURL, function (data) {
    $('#corkboard-title').html(data.title);
});

//write form action
let addPushpinPhpURL = "../../api/Pushpin/add_pushpin.php?corkboardId=" + corkboardId;
$('#submit-pushpin-btn').click(function(){
    $('#add-pushpin').attr('action', addPushpinPhpURL);
});


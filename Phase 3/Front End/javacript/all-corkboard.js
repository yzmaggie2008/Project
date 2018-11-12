var viewCorkboardURL = "view-corkboard.html?corkboardId="
//Set data to recent corkboard
$.getJSON("../../api/Corkboard/view_all_corkboards.php", function (data) {
    var recentCorkboardUL = "";

    if(data.message) {
        let noCorkboard = "<p>No Corkboards.</p>"
        $('#all-corkboard').html(noCorkboard);
    } else {
        $.each(data, function (k, v) {
            var recentCorlboardLi = "";
            if (v.privateID != 0) {
                recentCorlboardLi += '<p><strong><a href="' + viewCorkboardURL + v.corkboardID + '">' + v.title + '</a></strong><span class = "text-danger"> (Private) </span></strong><p>' +
                    '<p> Updated by <span><strong>' + v.user_name + '</strong></span> on <span><strong>' + v.date +
                    '</strong></span> at <span> <strong>' + v.time + '</strong></span></p>';
            } else {
                recentCorlboardLi += '<p><strong><a href="' + viewCorkboardURL + v.corkboardID + '">' + v.title + '</a></strong></p>' +
                    '<p> Updated by <span><strong>' + v.user_name + '</strong></span> on <span><strong>' + v.date +
                    '</strong></span> at <span> <strong>' + v.time + '</strong></span></p>';
            }
            recentCorkboardUL += "<li class=\"list-group-item\">" + recentCorlboardLi + "</li>";

        })
        $('#all-corkboard').html(recentCorkboardUL);
    }
});
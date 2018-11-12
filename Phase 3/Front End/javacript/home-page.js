var viewCorkboardURL = "view-corkboard.html?corkboardId="

//Set data to recent corkboard
$.getJSON("../../api/Corkboard/recentCorkboard.php", function (data) {
    var recentCorkboardUL = "";

    if(data.message) {
        let noCorkboard = "<p>No Corkboards.</p>"
        $('#recent-corkboard').html(noCorkboard);
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
        $('#recent-corkboard').html(recentCorkboardUL);
    }
});

//set data to my corkboard
$.getJSON("../../api/Corkboard/my_corkboard.php", function (data) {
    var myCorkboardUL = "";
    if(data.message) {
        let noCorkboard = "<p>You have no Corkboards.</p>"
        $('#my-corkboard').html(noCorkboard);
    } else {
        $.each(data, function (k, v) {
            console.log(v);
            let myCorlboardLi = "";
            if (v.privateID != null) {
                myCorlboardLi += '<p><span class="corkboard-titile"><strong><a href="' + viewCorkboardURL + v.corkboardID + '">' + v.title + '</a></span><span class="text-danger"> (Private) </span></strong> with <span class="pushpin-num">' + v.num + '</span> pushpins.</p>';
            } else {
                myCorlboardLi += '<p><span class="corkboard-titile"><strong><a href="' + viewCorkboardURL + v.corkboardID + '">' + v.title + '</a></strong> with <span class="pushpin-num">' + v.num + '</span> pushpins.</p>';
            }


            myCorkboardUL += "<li class=\"list-group-item\">" + myCorlboardLi + "</li>";
        })
        $('#my-corkboard').html(myCorkboardUL);
    }
});





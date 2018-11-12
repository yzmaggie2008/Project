var currentUser;
var currentEmail;

//handle email or password error on login page
var urlParams = new URLSearchParams(window.location.search);
// Check if the url is redirect from login.php
if (urlParams.get('wrong-password') == '1') {
    alert("Email or password not correct, please input again");
}

//Insert current user name
let sessionURL = "../../api/LogIn/get_session_info.php";
$.getJSON(sessionURL, function (data) {
    $('.insert-user-name').html(data.user_name);
    currentUser = data.user_name;
    currentEmail = data.email;
});


//convert ajax json to html table and red the current user
//source: https://stackoverflow.com/questions/1051061/convert-json-array-to-an-html-table-in-jquery
function insertDataToTable(url, tableId) {
    $.getJSON(url, function (data) {
        var tbl_body = "";
        $.each(data, function (key, value) {
            var tbl_row = "";
            $.each(this, function (k, v) {
                if(k == "email") {
                } else {
                   // console.log(v);
                    tbl_row += "<td>" + v + "</td>";
                }
            })
            console.log(currentEmail);
            console.log(value.email);
            if(value.email == currentEmail) {
                tbl_body += "<tr class='text-danger'>" + tbl_row + "</tr>";
            }else {
                // tbl_body += "<tr class='" + value.email + "'>" + tbl_row + "</tr>";
                tbl_body += "<tr>" + tbl_row + "</tr>";
            }
        })
        $(tableId).html(tbl_body);
    });
}

//Insert data to corkboard statistic page
let corkboardStatisticUrl = "../../api/Corkboard/corkboard_statistic.php";
let corkboardStatisticTableId = "#corkboard-statistic-table tbody";
insertDataToTable(corkboardStatisticUrl, corkboardStatisticTableId);


//Insert data to popular tags page
let popularTagUrl = "../../api/Pushpin/view_popular_tags.php";
let popularTagTableId = "#popular-tag-table tbody";
insertDataToTable(popularTagUrl, popularTagTableId);

//Insert data to popular sites page
let popularSiteUrl = "../../api/Pushpin/view_popular_site.php";
let popularSiteTableId = "#popular-site-table tbody";
insertDataToTable(popularSiteUrl, popularSiteTableId);

//Insert data to search pushpin page
let searchPushpinUrl = "../../api/Pushpin/view_search_pushpin.php?s=";
let searchPushpinTableId = "#search-pushpin-table tbody";
insertDataToTable(searchPushpinUrl,searchPushpinTableId);
//get category list
let getCategoryURL = "../../api/Corkboard/category.php";
$.getJSON(getCategoryURL, function (data) {
        var categoryList = "";

        // window.console&&console.log("hello");
        $.each(data, function (k, v) {
            console.log(v.category);
            categoryList += '<option value="' + v.category + '">' + v.category + '</option>';
        })
        $('#inputGroupSelect01').html(categoryList);

});





// Javascript
function redirect_home() {
    setTimeout("location.href = 'home.php';",1500);
}

$(document).bind("pageinit", function () {
    $.mobile.ajaxEnabled = false;
});

$(document).on("pagebeforeshow", function() {
    $("#navigation-button").click(function(){
        $("#left-panel").panel("open");
    });
    
    $("#user-nav-button").click(function(){
        $("#right-panel").panel("open");
    });
});
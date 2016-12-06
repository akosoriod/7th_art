var ActivitySetURL = null;
$(function(){
    ActivitySetURL = window.appUrl + "index.php/activitySet/";
      
    uptWallClearedDate()
    
    $("#clear-wall").click(function(event){
        $.ajax({
            url: ActivitySetURL + "clearWallByAjax",
            type: "GET",
            data: {}
        }).done(function (data) {
            var res = JSON.parse(data);
            console.log(res);
            uptWallClearedDate();
        });
   });
});


function uptWallClearedDate(){
     $.ajax({
        url: ActivitySetURL + "loadWallClearedDateByAjax",
        type: "GET",
        data: {}
    }).done(function (data) {
        var res = JSON.parse(data);
        $("#clear-wall-date").html(res.data[0].date);
    });
}
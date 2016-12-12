var ActivitySetURL = null;
$(function(){
    ActivitySetURL = window.appUrl + "index.php/activitySet/";
      
    uptWallClearedDate()
    
    $("#clear-wall").click(function(event){
        //TODO: Confirm action
        m_alert_action("Confirmar", "¿Desea limpiar los comentarios realizados en el Wall?", function(){
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
});


function uptWallClearedDate(){
     $.ajax({
        url: ActivitySetURL + "loadWallClearedDateByAjax",
        type: "GET",
        data: {}
    }).done(function (data) {
        var res = JSON.parse(data);
        if (res.data[0].date){
            $("#clear-wall-date").html(res.data[0].date);
        }else{
            $("#clear-wall-date").html("Nunca se ha efectuado la limpieza");
        }
    });
}
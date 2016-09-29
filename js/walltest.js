/* 
 * Universidad Nacional de Colombia
 * 7th @rt The Power & Magic of Films to Learn English
 * 7thart_bog@unal.edu.co
 * 2014
 */

function guardarComentario() {
    alert("Guardar Comentario");
}


function comentarioGuardado(data) {
    if (data.status == "success") {
        $("#formResult").html("Tu comentario se ha registrado.");
        $("#wall-form")[0].reset();
    } else if (data.status == "error") {
        $("#formResult").html("Tu comentario no se ha registrado.");
    } else {
        $.each(data, function (key, val) {
            $("#wall-form #" + key + "_em_").text(val);
            $("#wall-form #" + key + "_em_").show();
        });
    }
}

function errorCommentario(data){
    alert(data);
}
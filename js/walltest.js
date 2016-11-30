var CommmentURL;
var pages = [0, 0];
var TEMPLATE_COMMENT = null;
var TEMPLATE_NO_COMMENTS = null;
var commentIndex = null;
var walls = ["tabForum", "tabCAS"];
$(function () {
    resetPages();
    CommmentURL = window.appUrl + "index.php/comment/";
    $.ajax({
        url: CommmentURL + "loadTemplate",
        type: "POST",
        data: {}
    }).done(function (data) {
        TEMPLATE_COMMENT = data;
    });
    
    $.ajax({
        url: CommmentURL + "loadNoCommentsBlock",
        type: "POST",
        data: {}
    }).done(function (data) {
        TEMPLATE_NO_COMMENTS = data;
    });
});

$(function () {

    var navBar = $("#main-navbar");
    var location = window.location.href;
    var contains = location.indexOf("section/index/movie");
    var btns = $(".wall-access-btn");
    if (contains >= 0) {
        btns.show();
    }
    navBar.fadeIn(2000);
});

$(function () {
    var url = appUrl + "index.php/comment/createCommentByAjax";
    var inputComment = $("#taComment");
    inputComment.keydown(function (event) {
        if (event.keyCode === 13) {
            guardarComentario(url);
        }
    });
    $("#btnCrearComentario2").click(function () {
        guardarComentario(url);
    });

});


function abrirPanelComentarios() {
    $("#wall").dialog("open");
    resetPages();

    $("#Tab-Menu-Wall .ui-tabs-nav li a")[0].click();
    showComments(0, 0);
    //**********************************************
    //**********************************
    $.each(walls, function (index, id) {
        $("#" + id).removeAttr('title');
    });
}


function guardarComentario(url) {
    if (typeof editor === 'undefined' || editor === null) {
        return;
    }
    var btn = $("#btnCrearComentario2");
    btn.prop("disable", "true");
    var stepId = editor.currentStep;
    var comment = $.trim($("#taComment").val());
    if (comment.length === 0) {
        return;
    }
    $.ajax({
        url: url,
        type: "POST",
        data: {
            comentario: comment,
            stepid: stepId
        }}).done(function (data) {
        if (data) {
            data = JSON.parse(data);
            comentarioGuardado(data);
            btn.prop("disable", "false");
        }
    }).fail(function (error) {
        btn.prop("disable", "false");
        if (error.status === 403) {
            alert("Su sesión ha terminado, por favor ingrese de nuevo.");
            window.location = self.ajaxUrl;
        } else {
            if (callback) {
                callback(error);
            }
        }
    }
    );

}

function borrarComentario(id) {
    var comment = $("#comment-" + id);
    comment.remove();
    var panel = $("#" + walls[commentIndex]);
    if (comment.siblings().length === 0){
        preSetPanelContent(panel, false);
    }
    $.ajax({
        url: CommmentURL + "borrarComentario",
        type: "POST",
        data: {
            id: id
        }}).done(function (data) {
        if (data) {
            console.log("Comentario borrado")
        }
    }
    );
}




function comentarioGuardado(data) {
    if (data.status === "success") {
        var panel = $("#" + walls[commentIndex]);
        panel.find(".no-comments").each(function(){
            preSetPanelContent(panel, true);
        });

        var comp = _.template(TEMPLATE_COMMENT);
        var a = comp(data.comment);
        panel.prepend(a);
        $("#taComment").val("");
    } else if (data.status === "error") {
        $("#formResult").html("Tu comentario no se ha registrado.");
    } else {
        $.each(data, function (key, val) {
            $("#wall-form #" + key + "_em_").text(val);
            $("#wall-form #" + key + "_em_").show();
        });
    }
}

function errorCommentario(data) {
    alert(data);
}

function selectTab(event, ui) {
    var index = ui.index;
    $.ajax({
        url: CommmentURL + "tabidsession",
        type: "GET",
        data: {tab: index + 1}
    });

    if (index === commentIndex) {
        return;
    }
    commentIndex = index;
    showComments(index, pages[index]);
}
function showComments(index, page) {
    $.ajax({
        url: CommmentURL + "ShowCommentsOnTabByAjax",
        type: "POST",
        data: {
            tab: index + 1,
            stepid: editor.currentStep,
            page: page
        }
    }).done(function (data) {
        data = JSON.parse(data);
        var panel = $("#" + walls[index]);
        
        
        if (page === 0 && data.comments.length > 0) {
            preSetPanelContent(panel, true);
        }else{
            preSetPanelContent(panel, false);
        }


        var comp = _.template(TEMPLATE_COMMENT);
        for (var i in data.comments) {
            panel.append(comp(data.comments[i]));
            if (data.comments[i].own) {
                $("#comment-" + data.comments[i].id).hover(
                        function () {
                            $(this).addClass("mouseover");
                        }, function () {
                             $(this).removeClass("mouseover");
                }
                );

            }
        }
        try {
            var commentLimit = $("#comment-limit");
            commentLimit.remove();
            if (!data.limit) {
                panel.append("<span class='comment-limit' id='commment-limit'" + index +" onclick='showComments(" + index + ", " + ++pages[commentIndex] + ")'>See more... </span>");
            }

        } catch (e) {

        }
    });
}
function resetPages() {
    pages = [0, 0];
    commentIndex = 0;
}

function preSetPanelContent(panel, hasComments){
    if (hasComments){
        panel.empty();
    }else{
        if(panel.children().length === 0){
        panel.append(TEMPLATE_NO_COMMENTS);
    
        }
    }
    
}
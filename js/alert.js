function m_alert_action(title, message, mCallback) {
    var type = "action";
    m_alert(title, message, type, mCallback);
}

function m_alert_succes(title, message, mCallback) {
    var type = "success";
    m_alert(title, message, type, mCallback);
}
function m_alert_info(title, message, mCallback) {
    var type = "info";
    m_alert(title, message, type, mCallback);
}
function m_alert_danger(title, message, mCallback) {
    var type = "danger";
    m_alert(title, message, type, mCallback);
}
function m_alert_primary(title, message, mCallback) {
    var type = "action";
    m_alert(title, message, type, mCallback);
}


function m_alert(title, message, type, mCallback) {

    restoreModal(type);

//    $("#7th-alert").modal('show');

    if ($("#7th-alert").hasClass('in')) {
        $("#7th-alert").modal('hide');
    }

    $("#7th-alert").find(".modal-title").html();
    $("#7th-alert").find(".modal-title").html(title);

    $("#7th-alert").find(".modal-body p").html();
    $("#7th-alert").find(".modal-body p").html(message);

    $("#alert-accept").off("click");

    $("#alert-accept").on("click", function () {
        $("#7th-alert").modal('hide');
        if(mCallback){
            mCallback();
        }
    });

    $("#7th-alert").modal('show');
}

function restoreModal(type) {
    $("#7th-alert .modal-header").removeClass("");
}
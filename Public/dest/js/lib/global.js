function checkPhoneNumber(phone) {
    var reg = /^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8])|(19[7]))\d{8}$/;
    if (!phone) {
        return false;
    }
    return reg.test(phone);
}

function GetQueryString(name) {

   var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");

   var r = window.location.search.substr(1).match(reg);

   if (r!=null) return unescape(r[2]); return null;

}

function getInputParam(id) {
    var inputs = $("#" + id + ' input');
    var param = {};
    for (var i = 0; i< inputs.length; i++) {
        var tmp = inputs.eq(i);
        param[tmp.attr("name")] = tmp.val();
    }

    return param;
}

function jump(url) {
    console.log("url>>>", url);
    if (url == '-1') {
        history.go(-1);
    }
    if (!url) {
        return false;
    }
    window.location.href = url;
}
function notify(msg, theme) {
    alert(msg);
}
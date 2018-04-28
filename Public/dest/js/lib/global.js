function checkPhoneNumber(phone) {
    var reg =  /^[1-9]\d*$/;
    if (!phone) {
        return false;
    }
    var isNumber  = reg.test(phone);
    if (isNumber) {
        return phone.length === 11;
    }
    return false;
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
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

function jump(url) {
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
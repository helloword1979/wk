function checkPhoneNumber(phone) {
    var reg = /^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8])|(19[7]))\d{8}$/;
    if (!phone) {
        return false;
    }
    return reg.test(phone);
}

function notify(msg, theme) {
    alert(msg);
}
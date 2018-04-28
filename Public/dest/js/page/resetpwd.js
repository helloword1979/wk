/**
 * 注册点击事件
**/


$(document).ready(function(){
    // username login_pwd login_pwd_repeat deal_pwd deal_pwd_repeat captcha
    $("#confirm").click(function(){
        var param = getParam();
     
        var pwd_key = 'password';
        console.log('param, p', param);
        // 以下可以进行各种校验, 我做了手机号校验, 与二次密码相同校验.
        if (checkHasEmpty(param)) {
           return notify("请完整填写密码信息"); 
        }

        if (param[pwd_key] !== param[pwd_key + '_repeat']) {
            return notify("请确认登陆密码二次是否相同");
        }

        
        // TODO 发送注册请求成功后跳转.
        reset();

    });

});

function getParam() {
    var inputs = $("#before-login input");
    var param = {};
    for (var i = 0; i< inputs.length; i++) {
        var tmp = inputs.eq(i);
        console.log(tmp.attr("name"));
        param[tmp.attr("name")] = tmp.val();
    }

    return param;
}
function checkHasEmpty(param) {
    if (!param) {
        return true;
    }
    if (!param instanceof Object) {
        return true;
    }
    for (var key in param){
        if (!param[key]) {
            return true;
        }
    }
    return false;
}
// 登陆的ajax
function reset(data) {
    $.ajax({
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "/users/login" ,//url
        data: data,
        success: function (result) {
            alert("success");
        },
        error : function() {
            alert("异常！");
        }
    });
}

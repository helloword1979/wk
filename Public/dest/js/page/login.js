/**
 * 登陆界面的点击事件
**/

$(document).ready(function(){

    $("#login").click(function(){
        var param = {};
        var username = $("#username").val();
        var pwd = $("#password").val()
        if (!checkPhoneNumber(username)) {
            return alert("请输入合法的手机号码");
        }
        if (!pwd) {
            return alert("请输入密码");
        }
        param.account = $("#username").val();
        param.password = $("#password").val();
        // 当前打印的是用户名与密码
        console.log("param", param);
        login(param);
    });

    $("#register").click(function(){
        alert("暂未开放");
    });
});

// 登陆的ajax
function login(data) {
    $.ajax({
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "/Index.php/Home/Login/logincl" ,//url
        data: data,
        success: function (result) {
            if (result.status== 1) {
                location.href="/index.php/Home/Index/index/"
            }else{
                alert(result.msg);
            }
        },
        error : function() {
            alert("异常！");
        }
    });
}
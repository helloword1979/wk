$(document).ready(function(){

    $("#submit").click(function(){
        var params = getInputParam("form");
        for (var k in params) {
            if (!params[k]) {
                return notify("请正确填写兑换信息");
            }
        }
        transfer(params);
       
    });
});

// 登陆的ajax
function transfer(data) {
    $.ajax({
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "" ,//url
        data: data,
        success: function (result) {
            alert("success");
        },
        error : function() {
            alert("异常！");
        }
    });
}
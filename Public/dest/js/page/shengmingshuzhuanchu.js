var valid_number_reg = /^[+]{0,1}(\d+)$|^[+]{0,1}(\d+\.\d+)$/;
$(document).ready(function(){

    $("#submit").click(function(){
        var params = getInputParam("form");
        for (var k in params) {
            if (!params[k]) {
                return notify("请正确填写转出信息");
            }
        }
        console.log("params", params)
        if (!valid_number_reg.test(params.number)) {
             return notify("请正确填写转出数量");
        }
       transfer(params);
    });
});

// 登陆的ajax
function transfer(data) {
    $.ajax({
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "/Index.php/Home/Info/zrsms" ,//url
        data: data,
        success: function (result) {
            alert(result.msg);
        },
        error : function() {
            alert("异常！");
        }
    });
}
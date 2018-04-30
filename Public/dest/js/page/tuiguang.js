$(document).ready(function(){

    $(".info .item").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
        var type = $(this).attr("data-type");
        changeTab(type);
    });
});

function changeTab(tab) {
    // renderTable({}, tab);
    request(tab)
}
function renderTable(data, type) {
    var tHead = {
        a: ['序号', '时间', '被推荐人', '业绩'],
        b: ['序号', '时间', '二代', '业绩'],
        c: ['序号', '直推总额', '二代总额'],
    }[type];

    var table = $("#table");
    var html = '';
    // 渲染表头部份
    html += '<thead><tr>'
    for (var i = 0; i < tHead.length; i++) {
        html += '<th>' + tHead[i] + '</th>';
    }
    html += '</tr></thead>';
    table.html(html);

    html += '<tbody>';
    var ordernum = 0 ;
    if (type == 'a') {

        for (var i = 0; i < data.length; i++) {
            ordernum ++;
            html += '<tr><td>' + ordernum + '</td><td>'+ data[i].ue_regtime +'</td><td>' + data[i].ue_account +'</td><td>' + 0 +'</td></tr>';
        }
    }
    if (type == 'b') {
        for (var i = 0; i < data.length; i++) {
            ordernum ++;
            html += '<tr><td>' + ordernum + '</td><td>'+ data[i].ue_regtime +'</td><td>' + data[i].ue_account +'</td><td>' + 0 +'</td></tr>';
        }
    }
    if (type == 'c') {
        alert('暂未开发');
    }
    html += '</tbody></table>';
    table.html(html);
   
}

function request(type) {
    $.ajax({
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "/index.php/Home/info/myspred/" ,//url
        data: {type: type},
        success: function (result) {
            renderTable(result.data,result.type);
        },
        error : function() {
            alert("异常！");
        }
    });
}

function getTenGrades() {
    alert('');
}


function postAjaxTen(url, prams, dom) {
    $.post(url, prams, function (data) {
        var html = '';
        // let tenGradesArr = new Array();
        for(let j = 0; j < data.length; j++){
            let obj = data[j];
            let gradesArr = [];
            for (var i in obj){
                gradesArr.push(obj[i]);
            }
            html += "<tr><td>"+ gradesArr[0] +"</td><td>"+ gradesArr[1] +"</td></td></tr>";
        }
        dom.html(html);
        return false;
    });
}

function getClassGrades(url, prams, dom) {
    $.post(url, prams, function (data) {
        var html = '';
        $.each(data, function (index, value) {
            html += "<tr><td>"+ value.stu_name +"</td><td>"+ value.chinese +"</td><td>"+ value.math +"</td>" +
                "<td>"+ value.english +"</td><td>"+ value.political +"</td><td>"+ value.history +"</td>" +
                "<td>"+ value.biology +"</td><td>"+ value.geography +"</td><td>"+ value.chemical +"</td>" +
                "<td>"+ value.physical +"</td><td>"+ value.total_points +"</td>" +
                "<td>"+ value.class_ranking +"</td><td>"+ value.grade_ranking +"</td></tr>";
        })
        dom.html(html);
    });
}

function showStudentAllGrades(url, prams, dom) {
    $.post(url, prams, function (data) {
        var html = '';
        // table(data);
        $.each(data, function (index, value) {
        //     // index => 姓名
            let arr = Object.keys(value);
            var arrLen = arr.length;
            html += table(value, arrLen);
        })
        dom.html(html);
        return false;
    })
}

function table(data, len = 0) {
    // 1.通过传参 index 来生成 tr 的数量
    // 2.传参 data 则是显示的数据
    let html = "<table class='table table-hover show_grades'><thead><th>姓名</th><th>学期</th><th>时间</th><th>班级排名</th><th>年级排名</th><th>语文</th><th>数学</th><th>英语</th><th>政治</th><th>物理</th><th>历史</th><th>地理</th><th>生物</th><th>化学</th><th>总分</th></thead><tbody>";
    // console.log(data);
    $.each(data, function (index, value) {
        var keysArr = getObjectKeys(value);
        var jsonValue = JSON.stringify(value);
        var jsonArr = $.parseJSON(jsonValue);
        html += "<tr>";
        for(let i = 0; i < keysArr.length; i++){
            html += "<td>" + jsonArr[keysArr[i]] +"</td>";
        }
        html += "</tr>";
    })
    html = html + "</tbody></table>";
    // console.log(html);
    return html;

}

function getObjectKeys(object)
{
    var keys = [];
    for (var property in object)
        keys.push(property);
    return keys;
}

function showStudentProgress(url, prams, dom) {
    $.post(url, prams, function (data) {
        var html = '';
        $.each(data, function (index, value) {
            html += "<tr><td>" + value.stu_name + "</td><td>" + value.first_ranking + "</td>" +
                "<td>" + value.last_ranking + "</td><td>" + value.change + "</td></tr>";
        });
        // console.log(data);
        dom.html(html);
        return false;
    })
}
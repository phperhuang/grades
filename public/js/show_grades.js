
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
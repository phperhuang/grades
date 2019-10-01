
function postAjax(url, prams, dom) {
    $.post(url, prams, function (data) {
        html = getNum(data);
        // console.log(html);
        dom.html(html);
        return false;
        // var html = '';
        // var classArr =  new Array();
        // var chineseArr =  new Array();
        // var mathArr =  new Array();
        // var englishArr =  new Array();
        // var politicalArr =  new Array();
        // var historyArr =  new Array();
        // var biologyArr =  new Array();
        // var geographyArr =  new Array();
        // var sortArr = new Array();
        // var allArr = new Array();
        // if(data.length != 0){
        //     $.each(data, function (index, value) {
        //         html += addHtml(value);
        //         classArr.push(value.class);
        //         chineseArr.push(value.chinese);
        //         mathArr.push(value.math);
        //         englishArr.push(value.english);
        //         politicalArr.push(value.political);
        //         historyArr.push(value.history);
        //         biologyArr.push(value.biology);
        //         geographyArr.push(value.geography);
        //     });
        //     // console.log(chineseArr);
        //     dom.html(html);
        //     let tr_length = dom.find('tr').length;
        //     let td_length = (dom.find('td').length / tr_length) - 1;
        //
        //     for (let i = 1; i <= td_length; i++){
        //         for (let j = 0; j < tr_length; j++){
        //             sortArr.push(dom.find('tr').eq(j).find('td').eq(i).text());
        //         }
        //         allArr.push(sortArr);
        //     }
        //     sortArr = sortArr.sort();
        //     // console.log(sortArr);
        //
        //     for (let i = 1; i <= td_length; i++){
        //         for (let j = 0; j < tr_length; j++){
        //             let old_text = dom.find('tr').eq(j).find('td').eq(i).text();
        //             // dom.find('tr').eq(j).find('td').eq(i).text(old_text + 123);
        //             dom.find('tr').eq(j).find('td').eq(i).text(old_text);
        //         }
        //     }
        //
        //     var myChart = echarts.init(document.getElementById('grades'));
        //     // 指定图表的配置项和数据
        //     var option = {
        //         title: {text: '各科成绩排行'},
        //         tooltip: {},
        //         legend: {
        //             // data:['语文分数']
        //         },
        //         xAxis: {
        //             type: 'category',
        //             data: classArr
        //         },
        //         yAxis: {},
        //         series: [{
        //             name: '语文成绩',
        //             type: 'bar',
        //             data: chineseArr
        //         },{
        //             name: '数学成绩',
        //             type: 'bar',
        //             data: mathArr
        //         },{
        //             name: '英语成绩',
        //             type: 'bar',
        //             data: englishArr
        //         },{
        //             name: '政治成绩',
        //             type: 'bar',
        //             data: politicalArr
        //         },{
        //             name: '历史成绩',
        //             type: 'bar',
        //             data: historyArr
        //         },{
        //             name: '生物成绩',
        //             type: 'bar',
        //             data: biologyArr
        //         },{
        //             name: '地理成绩',
        //             type: 'bar',
        //             data: geographyArr
        //         }]
        //     };
        //     // 使用刚指定的配置项和数据显示图表。
        //     myChart.setOption(option);
        //
        // }else{
        //     layer.alert('暂时没有记录');
        // }

    });
}

function getNum(obj) {
    var html = '';
    var chineseArr = new Array();
    var mathArr =  new Array();
    var englishArr =  new Array();
    var politicalArr =  new Array();
    var historyArr =  new Array();
    var biologyArr =  new Array();
    var geographyArr =  new Array();
    var chemicalArr =  new Array();
    var physicalArr =  new Array();
    for(let j = 0; j < obj.length; j++){
        chineseArr.push(obj[j]['chinese']);
        mathArr.push(obj[j]['math']);
        englishArr.push(obj[j]['english']);
        politicalArr.push(obj[j]['political']);
        historyArr.push(obj[j]['history']);
        biologyArr.push(obj[j]['biology']);
        geographyArr.push(obj[j]['geography']);
        chemicalArr.push(obj[j]['chemical']);
        physicalArr.push(obj[j]['physical']);
    }
    chineseArr.sort(function (a,b) {return b - a;});
    mathArr.sort(function (a,b) {return b - a;});
    englishArr.sort(function (a,b) {return b - a;});
    politicalArr.sort(function (a,b) {return b - a;});
    historyArr.sort(function (a,b) {return b - a;});
    biologyArr.sort(function (a,b) {return b - a;});
    geographyArr.sort(function (a,b) {return b - a;});
    for(var i = 0; i < obj.length; i++){
        html += "<tr><td>"+ obj[i]['class'] +"</td>" +
            "<td>"+ obj[i]['chinese'] + "<span class='num'>" + (contains(chineseArr, obj[i]['chinese']) + 1) +"</span></td>" +
            "<td>"+ obj[i]['math'] + "<span class='num'>" + (contains(mathArr, obj[i]['math']) + 1) +"</span></td>" +
            "<td>"+ obj[i]['english'] + "<span class='num'>" + (contains(englishArr, obj[i]['english']) + 1) +"</span></td>" +
            "<td>"+ obj[i]['chemical'] + "<span class='num'>" + (contains(chemicalArr, obj[i]['chemical']) + 1) +"</span></td>" +
            "<td>"+ obj[i]['political'] + "<span class='num'>" + (contains(politicalArr, obj[i]['political']) + 1) +"</span></td>" +
            "<td>"+ obj[i]['history'] + "<span class='num'>" + (contains(historyArr, obj[i]['history']) + 1) +"</span></td>" +
            "<td>"+ obj[i]['geography'] + "<span class='num'>" + (contains(geographyArr, obj[i]['geography']) + 1) +"</span></td>" +
            "<td>"+ obj[i]['biology'] + "<span class='num'>" + (contains(biologyArr, obj[i]['biology']) + 1) +"</span></td>" +
            "<td>"+ obj[i]['physical'] + "<span class='num'>" + (contains(physicalArr, obj[i]['physical']) + 1) +"</span></td></tr>";
    }
    return html;
}

// 获取年级排名
function contains(arrays, obj) {
    var i = arrays.length;
    while (i--) {
        if (arrays[i] === obj) {
            return i;
        }
    }

    return false;
}

function postAjax(url, prams, dom) {
    $.post(url, prams, function (data) {
        var html = '';
        var classArr =  new Array();
        var chineseArr =  new Array();
        var mathArr =  new Array();
        var englishArr =  new Array();
        var politicalArr =  new Array();
        var historyArr =  new Array();
        var biologyArr =  new Array();
        var geographyArr =  new Array();
        var sortArr = new Array();
        var allArr = new Array();
        if(data.length != 0){
            $.each(data, function (index, value) {
                html += addHtml(value);
                classArr.push(value.class);
                chineseArr.push(value.chinese);
                mathArr.push(value.math);
                englishArr.push(value.english);
                politicalArr.push(value.political);
                historyArr.push(value.history);
                biologyArr.push(value.biology);
                geographyArr.push(value.geography);
            });
            dom.html(html);
            let tr_length = dom.find('tr').length;
            let td_length = (dom.find('td').length / tr_length) - 1;

            for (let i = 1; i <= td_length; i++){
                for (let j = 0; j < tr_length; j++){
                    sortArr.push(dom.find('tr').eq(j).find('td').eq(i).text());
                }
                allArr.push(sortArr);
                sortArr.empty();
                console.log(sortArr);
            }
            sortArr = sortArr.sort();
            // console.log(sortArr);

            for (let i = 1; i <= td_length; i++){
                for (let j = 0; j < tr_length; j++){
                    let old_text = dom.find('tr').eq(j).find('td').eq(i).text();
                    dom.find('tr').eq(j).find('td').eq(i).text(old_text + 123);
                }
            }

            var myChart = echarts.init(document.getElementById('grades'));
            // 指定图表的配置项和数据
            var option = {
                title: {text: '各科成绩排行'},
                tooltip: {},
                legend: {
                    // data:['语文分数']
                },
                xAxis: {
                    type: 'category',
                    data: classArr
                },
                yAxis: {},
                series: [{
                    name: '语文成绩',
                    type: 'bar',
                    data: chineseArr
                },{
                    name: '数学成绩',
                    type: 'bar',
                    data: mathArr
                },{
                    name: '英语成绩',
                    type: 'bar',
                    data: englishArr
                },{
                    name: '政治成绩',
                    type: 'bar',
                    data: politicalArr
                },{
                    name: '历史成绩',
                    type: 'bar',
                    data: historyArr
                },{
                    name: '生物成绩',
                    type: 'bar',
                    data: biologyArr
                },{
                    name: '地理成绩',
                    type: 'bar',
                    data: geographyArr
                }]
            };
            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);

        }else{
            layer.alert('暂时没有记录');
        }

    });
}


function addHtml(value) {
    return "<tr><td>"+ value.class +"</td><td>"+ value.chinese +"</td><td>"+ value.math +"</td><td>"+ value.english +"</td>" +
        "<td>"+ value.political +"</td><td>"+ value.history +"</td><td>"+ value.biology +"</td><td>"+ value.geography +"</td></tr>";
}


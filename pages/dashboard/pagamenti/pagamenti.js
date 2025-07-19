function hightChart(year){
    $.post('post/dashboard_pagamenti.php',{year:year}).done((data)=>{
        try {
            const parsed = typeof data === 'string' ? JSON.parse(data) : data;
            loadChart(parsed);
        } catch (e) {
            console.error('Invalid JSON:', e);
            fail();
        }
    }).fail(()=>fail());
}

function loadChart(data){
    console.log(data);
    const dataObject = Object.fromEntries(
        Object.entries(data).map(([key, values]) => [
            key,
            values.map(y => ({ y }))
        ])
    );

    function getData(type){
        return dataObject[type];
    }

    Highcharts.chart('container', {
        accessibility:{
            enabled:false
        },
        chart: {
            type: 'column'
        },
        credits:{
            enabled:false
        },
        title: {
            enabled:false,
            text: ''
        },
        xAxis: {
            categories: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Oto','Nov','Dic'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                enabled:false,
                text: ''
            }
        },
        tooltip: {
            shared: true,
            useHTML: true,
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y}</b><br/>'
        },
        plotOptions: {
            column: {
                pointPadding: 0.05,
                groupPadding: 0.05,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'Pos',
                data: getData('Pos'),
            }, 
            {
                name: 'Contanti',
                pointPlacement: -0.1,
                data: getData('Contanti'),
            },
            {
                name: 'Bonifico',
                pointPlacement: -0.2,
                data: getData('Bonifico'),
            }
            
        ]
    });
}

document.addEventListener('DOMContentLoaded', function () {
    hightChart(new Date().getFullYear());
});

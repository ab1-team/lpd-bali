$(function(){
    // just a class wrapper for convenience
    function myClock(size = 300, attrib) { return new _myClock(size, attrib) }
    
    // the class
    class _myClock  {
      constructor(size, attrib) {
        this.size = size
        const cx = size/2, cy = size/2;  // Radius
        const _clockstyle = "width: " + (size) + "px;  height: " + (size) + "px;"
          + "border: 7px solid #282828; background: #585858;"
          + "border-radius: 50%; margin: 50px;"
          + "box-shadow: -4px -4px 10px rgba(67,67,67,0.5), inset 4px 4px 10px rgba(0,0,0,0.5),"
          + "inset -4px -4px 10px rgba(67,67,67,0.5), 4px 4px 10px rgba(0,0,0,0.3);"
    
        this.base = sidiv("", _clockstyle+attrib)
        let c = this.canvas = canvas2D({ width: px(2 * cx), height: px(2 * cy) })
    
        c.ctx.lineCap = "round"
        unselectBase()
    
        // Paint anything radial
        function tick(color, width, angle, length, innerlength = 0) {
          function ls(length) { return length * Math.sin(angle / 180.0 * Math.PI) }
          function lc(length) { return -length * Math.cos(angle / 180.0 * Math.PI) }
          c.setLineType(width, color)
          c.line(cx + ls(innerlength), cy + lc(innerlength), cx + ls(length), cy + lc(length))
        }
    
        // Draw clock
        function drawClock() {
          c.clear()
          // Draw ticks
          for (let i = 0; i < 360; i += 30)
            if ((i % 90) == 0) tick("#1df52f", 5, i, size*0.45, size*0.40)
            else tick("#bdbdcb", 3, i,  size*0.45, size*0.43)
    
          // draw hands
          let t = new Date();  // get time
          tick("#61afff", 5, t.getHours() * 30, size*0.25)  // hour
          tick("#71afff", 2, t.getMinutes() * 6, size*0.35)  // min
          tick("#ee791a", 2, t.getSeconds() * 6, size*0.42)  // s
    
          // drwa center
          c.setFillStyle("#4d4b63")
          c.circle(cx, cy, 10, { fill: true })
        }
        drawClock()
        setInterval(drawClock, 1000)
      }
    }

    function initFlot(){
        var data1 = [
                [1, 20],
                [2, 20],
                [3, 40],
                [4, 30],
                [5, 40],
                [6, 35],
                [7, 47]
            ],
            data2 = [
                [1, 13],
                [2, 8],
                [3, 17],
                [4, 10],
                [5, 17],
                [6, 15],
                [7, 16]
            ],
            data3 = [
                [1, 23],
                [2, 13],
                [3, 33],
                [4, 16],
                [5, 32],
                [6, 28],
                [7, 31]
            ],
            $chart = $("#flot-main"),
            $tooltip = $('#flot-main-tooltip');

        function _initChart(){
            var plot = $.plotAnimator($chart, [{
                label: "Traffic",
                data: data3,
                lines: {
                    fill: .3,
                    lineWidth: 0
                },
                color:['#ccc']
            },{
                label: "Traffic",
                data: data2,
                lines: {
                    fill: 0.6,
                    lineWidth: 0
                },
                color:['#F7653F']
            },{
                label: "Traffic",
                data: data1,
                animator: {steps: 60, duration: 1000, start:0},
                lines: {lineWidth:2},
                shadowSize:0,
                color: '#F7553F'
            }],{
                xaxis: {
                    tickLength: 0,
                    tickDecimals: 0,
                    min:2,
                    font :{
                        lineHeight: 13,
                        weight: "bold",
                        color: Sing.colors['gray-semi-light']
                    }
                },
                yaxis: {
                    tickDecimals: 0,
                    tickColor: "#f3f3f3",
                    font :{
                        lineHeight: 13,
                        weight: "bold",
                        color: Sing.colors['gray-semi-light']
                    }
                },
                grid: {
                    backgroundColor: { colors: [ "#fff", "#fff" ] },
                    borderWidth:1,
                    borderColor:"#f0f0f0",
                    margin:0,
                    minBorderMargin:0,
                    labelMargin:20,
                    hoverable: true,
                    clickable: true,
                    mouseActiveRadius:6
                },
                legend: false
            });

            $chart.on("plothover", function (event, pos, item) {
                if (item) {
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    $tooltip.html(item.series.label + " at " + x + ": " + y)
                        .css({
                            top: item.pageY + 5 - window.scrollY,
                            left: item.pageX + 5 - window.scrollX
                        })
                        .fadeIn(200);
                } else {
                    $tooltip.hide();
                }
            });
        }

        _initChart();

        SingApp.onResize(_initChart);
    }

    function initRickshaw(){
        "use strict";

        var seriesData = [ [], [] ];
        var random = new Rickshaw.Fixtures.RandomData(30);

        for (var i = 0; i < 30; i++) {
            random.addData(seriesData);
        }

        var graph = new Rickshaw.Graph( {
            element: document.getElementById("rickshaw"),
            height: 130,
            renderer: 'area',
            series: [
                {
                    color: '#96E593',
                    data: seriesData[0],
                    name: 'Uploads'
                }, {
                    color: '#ecfaec',
                    data: seriesData[1],
                    name: 'Downloads'
                }
            ]
        } );

        function onResize(){
            graph.configure({
                width: $('#realtime1').width()
            });
            graph.render();
        }

        SingApp.onResize(onResize);
        onResize();


        var hoverDetail = new Rickshaw.Graph.HoverDetail( {
            graph: graph,
            xFormatter: function(x) {
                return new Date(x * 1000).toString();
            }
        } );

        setInterval( function() {
            random.removeData(seriesData);
            random.addData(seriesData);
            graph.update();

        }, 1000 );
    }

    function initSparkline1(){
        function _initChart(){
            $('#sparkline1').sparkline([2,4,6,2,7,5,3,7,8,3,6],{
                width: '100%',
                fillColor: '#ddd',
                height: '100px',
                lineColor: 'transparent',
                spotColor: '#c0d0f0',
                minSpotColor: null,
                maxSpotColor: null,
                highlightSpotColor: '#ddd',
                highlightLineColor: '#ddd'
            }).sparkline([5,3,7,8,3,6,2,4,6,2,7],{
                composite: true,
                lineColor: 'transparent',
                spotColor: '#c0d0f0',
                fillColor: 'rgba(192, 208, 240, 0.76)',
                minSpotColor: null,
                maxSpotColor: null,
                highlightSpotColor: '#ddd',
                highlightLineColor: '#ddd'
            })
        }

        _initChart();

        SingApp.onResize(_initChart);
    }

    function initSparkline2(){
        $('#sparkline2').sparkline([2,4,6],{
            type: 'pie',
            width: '100px',
            height: '100px',
            sliceColors: ['#F5CB7B', '#FAEEE5', '#f0f0f0']
        });
    }

    /* Inspired by Lee Byron's test data generator. */
    function _stream_layers(n, m, o) {
        // n = 4
        // m = 12
        // o = .1
        if (arguments.length < 3) o = 0;
        function bump(a) {
            var x = 1 / (.1 + Math.random()),
                y = 2 * Math.random() - .5,
                z = 10 / (.1 + Math.random());
            for (var i = 0; i < m; i++) {
                var w = (i / m - y) * z;
                a[i] += x * Math.exp(-w * w);
            }
        }
        return d3.range(n).map(function() {
            var a = [], i;
            for (i = 0; i < m; i++) a[i] = o + o * Math.random();
            for (i = 0; i < 5; i++) bump(a);
            return a.map(function(d, i) {
                return {
                    x: i,
                    y: Math.max(0, d)
                };
            });
        });
    }

    function testData(stream_names, pointsCount) {
        var now = new Date().getTime(),
            day = (1000 * 60 * 60 * 24), //milliseconds
            daysAgoCount = 365,
            daysAgo = daysAgoCount * day,
            daysAgoDate = now - daysAgo,
            pointsCount = pointsCount || 45, //less for better performance
            daysPerPoint = daysAgoCount / pointsCount;
        return _stream_layers(stream_names.length, pointsCount, .1).map(function(data, i) {
            return {
                key: stream_names[i],
                values: data.map(function(d,j){
                    return {
                        x: daysAgoDate + d.x * day * daysPerPoint,
                        y: Math.floor(d.y * 100) //just a coefficient,
                    }
                })
            };
        });
    }
    
    // async function getData() {
    //     var data = []
    //     await $.ajax({
    //         url : '../inc/chart_kab.php',
    //         type : 'GET',
    //         data : '',
    //         success: function(result) {
    //             result = JSON.parse(result)
                
    //             for(i = 0; i < result.length; i++) {
    //                 data.push({
    //                     "label": "" + result[i][0].kec + "",
    //                     "value": result[i][0].ap
    //                 })
    //             }
                
    //         }
    //     })
    // }
    
    function initNvd32Donut() {
        var data = []
        $.ajax({
            url : '../inc/chart_kab.php',
            type : 'GET',
            data : '',
            success: function(result) {
                result = JSON.parse(result)
                
                for(i = 0; i < result.length; i++) {
                    data.push({
                        "label": "" + result[i][0].kec + "",
                        "value": result[i][0].ap
                    })
                }
                
                nv.addGraph(function() {
                    var chart = nv.models.pieChart().x(function(d) {
                        return d.label
                    }).y(function(d) {
                        return d.value
                    }).showLabels(true).labelThreshold(.05).labelType("percent").donut(true).donutRatio(0.35) 
                    d3.select('#nvd32 svg').style('height', '300px').datum(data).transition().duration(350).call(chart);
                
                    return chart;
                });
                
            }
        })
    }

    function initNvd31(){

        nv.addGraph(function() {
            var chart = nv.models.lineChart()
                .useInteractiveGuideline(true)
                .margin({left: 28, bottom: 30, right: 0})
                .color(['#82DFD6', '#ddd']);

            chart.xAxis
                .showMaxMin(false)
                .ticks(1000)
                .tickFormat(function(d) { return d3.time.format('%b %d')(new Date(d)) });

            chart.yAxis
                .showMaxMin(false)
                .ticks(0)
                .tickFormat(d3.format(',f'));

            d3.select('#nvd31 svg')
                .style('height', '300px')
                .datum(testData(['Search', 'Referral'], 50).map(function(el, i){
                    el.area = true;
                    return el;
                }))
                .transition().duration(500)
                .call(chart)
            ;


            SingApp.onResize(chart.update);

            return chart;
        });
    }

// Chart Buru
    function initNvd32(){
        nv.addGraph(function() {
            var chart = nv.models.multiBarChart().margin({left: 28, bottom: 30, right: 0}).color(['#5d8fc2', '#f0b518', '#64bd63', '#F7653F']);

            chart.xAxis.showMaxMin(false).ticks(700).tickFormat(function(d) { return d3.time.format('%b %d')(new Date(d)) });

            chart.yAxis.showMaxMin(false).ticks(0).tickFormat(d3.format(',f'));

//            chart.controls.margin({left: 0});

            d3.select('#nvd32 svg').style('height', '300px').datum(testData(['Cabang1', 'Cabang2', 'Cabang3', 'Cabang4'], 12).map(function(el, i){
                    el.area = true;
                    return el;
                })).transition().duration(500).call(chart);

            SingApp.onResize(chart.update);
            return chart;
        });
    }

    function initMorris1(){
        Morris.Line({
            element: 'morris1',
            resize: true,
            data: [
                { y: '2006', a: 100, b: 90 },
                { y: '2007', a: 75,  b: 65 },
                { y: '2008', a: 50,  b: 40 },
                { y: '2009', a: 75,  b: 65 },
                { y: '2010', a: 50,  b: 40 },
                { y: '2011', a: 75,  b: 65 },
                { y: '2012', a: 100, b: 90 }
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Series A', 'Series B'],
            lineColors: ['#88C4EE', '#ccc']
        });
    }

    function initMorris2(){
        Morris.Area({
            element: 'morris2',
            height: '200px',
            resize: true,
            data: [
                { y: '2006', a: 100, b: 90 },
                { y: '2007', a: 75,  b: 65 },
                { y: '2008', a: 50,  b: 40 },
                { y: '2009', a: 75,  b: 65 },
                { y: '2010', a: 50,  b: 40 },
                { y: '2011', a: 75,  b: 65 },
                { y: '2012', a: 100, b: 90 }
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Series A', 'Series B'],
            lineColors: ['#80DE78', '#9EEE9B'],
            lineWidth: 0
        });
    }

    function initMorris3(){
        $('#morris3').css({height: 180});
        Morris.Donut({
            element: 'morris3',
            data: [
                {label: "Asset Bank", value: 12},
                {label: "Asset Piutang", value: 30},
                {label: "Asset Kas", value: 20}
            ],
            colors: ['#F7653F', '#F8C0A2', '#e6e6e6']
        });

    }

    function initEasyPie(){
        $('#easy-pie1').easyPieChart({
            barColor: '#5dc4bf',
            trackColor: '#ddd',
            scaleColor: false,
            lineWidth: 10,
            size: 120
        });
    }

    function initFlotBar(){
        var bar_customised_1 = [[1388534400000, 120], [1391212800000, 70],  [1393632000000, 100], [1396310400000, 60], [1398902400000, 35]];
        var bar_customised_2 = [[1388534400000, 90], [1391212800000, 60], [1393632000000, 30], [1396310400000, 73], [1398902400000, 30]];
        var bar_customised_3 = [[1388534400000, 80], [1391212800000, 40], [1393632000000, 47], [1396310400000, 22], [1398902400000, 24]];

        var data = [
            {
                label: "Apple",
                data: bar_customised_1,
                bars: {
                    show: true,
                    barWidth: 12*24*60*60*300,
                    fill: true,
                    lineWidth:0,
                    order: 1
                }
            },
            {
                label: "Google",
                data: bar_customised_2,
                bars: {
                    show: true,
                    barWidth: 12*24*60*60*300,
                    fill: true,
                    lineWidth: 0,
                    order: 2
                }
            },
            {
                label: "Facebook",
                data: bar_customised_3,
                bars: {
                    show: true,
                    barWidth: 12*24*60*60*300,
                    fill: true,
                    lineWidth: 0,
                    order: 3
                }
            }

        ];

        function _initChart(){
            $.plot($("#flot-bar"), data, {
                series: {
                    bars: {
                        show: true,
                        barWidth: 12*24*60*60*350,
                        lineWidth: 0,
                        order: 1,
                        fillColor: {
                            colors: [{
                                opacity: 1
                            }, {
                                opacity: 0.7
                            }]
                        }
                    }
                },
                xaxis: {
                    mode: "time",
                    min: 1387497600000,
                    max: 1400112000000,
                    tickLength: 0,
                    tickSize: [1, "month"],
                    axisLabel: 'Month',
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 13,
                    axisLabelPadding: 15
                },
                yaxis: {
                    axisLabel: 'Value',
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 13,
                    axisLabelPadding: 5
                },
                grid: {
                    hoverable: true,
                    borderWidth: 0
                },
                legend: {
                    backgroundColor: "transparent",
                    labelBoxBorderColor: "none"
                },
                colors: ["#64bd63", "#f0b518", "#F7653F"]
            });
        }

        _initChart();

        SingApp.onResize(_initChart);


    }

    function pageLoad(){
        $('.widget').widgster();
        $('.sparkline').each(function(){
            $(this).sparkline('html', $(this).data());
        });

        //initFlot();
        //initRickshaw();
        //initSparkline1();
        //initSparkline2();
        //initNvd31();
        initNvd32Donut();
        //initMorris1();
        //initMorris2();
        //initMorris3();
        //initEasyPie();
        //initFlotBar();
    }
    pageLoad();
    SingApp.onPageLoad(pageLoad);
});